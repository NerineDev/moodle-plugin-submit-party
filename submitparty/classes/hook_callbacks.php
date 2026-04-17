<?php
namespace block_submitparty;

// En esta clase centralizo el hook visual del plugin.
// La idea es aprovechar el footer de Moodle para insertar un script ligero que
// muestre una celebracion cuando el observador haya dejado la marca en sesion.
class hook_callbacks {
    // Este callback se ejecuta justo antes de que Moodle cierre el HTML final.
    public static function inject_celebration(\core\hook\output\before_footer_html_generation $hook) {
        global $SESSION, $DB, $USER;

        // Si no hay marca en sesion, no hago nada para no ensuciar otras paginas.
        if (empty($SESSION->submitparty_timecreated)) {
            return;
        }

        // Limpio la sesion enseguida para que la animacion solo se dispare una vez.
        unset($SESSION->submitparty_timecreated);
        $DB->set_field('block_submitparty_log', 'celebrated', 1, ['userid' => $USER->id]);

        // Inserto un script autocontenido con varias animaciones simples.
        // Aqui elegi esta estrategia para no depender del bloque visible en pantalla.
        $hook->add_html('<script>
(function() {
    // Elijo una animacion aleatoria para que la experiencia no sea siempre igual.
    var r = Math.random();
    if (r < 0.20) { runConfetti(); }
    else if (r < 0.40) { runFireworks(); }
    else if (r < 0.70) { runBalloons(); }
    else { runEmoji(); }

    // Esta opcion dibuja confeti con canvas y lo elimina al terminar.
    function runConfetti() {
        var canvas = makeCanvas();
        var ctx = canvas.getContext("2d");
        var colors = ["#ff4d6d","#4dabf7","#ffd43b","#9775fa","#6ecb63","#ff8fab","#ff922b"];
        var pieces = [];
        for (var i = 0; i < 180; i++) {
            pieces.push({
                x: Math.random() * canvas.width,
                y: Math.random() * canvas.height - canvas.height,
                w: Math.random() * 12 + 5, h: Math.random() * 6 + 3,
                color: colors[Math.floor(Math.random() * colors.length)],
                vx: Math.random() * 4 - 2, vy: Math.random() * 4 + 2,
                angle: Math.random() * 360, spin: Math.random() * 8 - 4, alpha: 1
            });
        }
        var rafId;
        function draw() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            var alive = false;
            pieces.forEach(function(p) {
                p.x += p.vx; p.y += p.vy; p.angle += p.spin; p.alpha -= 0.004;
                if (p.y < canvas.height && p.alpha > 0) alive = true;
                ctx.save(); ctx.globalAlpha = Math.max(0, p.alpha);
                ctx.translate(p.x, p.y); ctx.rotate(p.angle * Math.PI / 180);
                ctx.fillStyle = p.color; ctx.fillRect(-p.w/2, -p.h/2, p.w, p.h);
                ctx.restore();
            });
            if (alive) { rafId = requestAnimationFrame(draw); } else { canvas.remove(); }
        }
        rafId = requestAnimationFrame(draw);
        setTimeout(function() { cancelAnimationFrame(rafId); if (canvas.parentNode) canvas.remove(); }, 6000);
    }

    // Esta variante lanza cohetes y despues particulas simulando fuegos artificiales.
    function runFireworks() {
        var canvas = makeCanvas();
        var ctx = canvas.getContext("2d");
        var particles = [];
        var rockets = [];
        function addRocket() {
            rockets.push({
                x: 150 + Math.random() * (canvas.width - 300),
                y: canvas.height,
                tx: 100 + Math.random() * (canvas.width - 200),
                ty: 60 + Math.random() * (canvas.height * 0.4),
                speed: 12,
                hue: Math.random() * 360
            });
        }
        function explode(x, y, hue) {
            for (var i = 0; i < 120; i++) {
                var angle = (Math.PI * 2 / 120) * i;
                var speed = Math.random() * 5 + 2;
                particles.push({
                    x: x, y: y,
                    vx: Math.cos(angle) * speed, vy: Math.sin(angle) * speed,
                    alpha: 1, hue: hue + Math.random() * 50 - 25,
                    decay: Math.random() * 0.025 + 0.02
                });
            }
        }
        var count = 0; var rafId;
        addRocket(); addRocket(); addRocket();
        function draw() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            rockets = rockets.filter(function(r) {
                var dx = r.tx - r.x, dy = r.ty - r.y;
                var dist = Math.sqrt(dx*dx + dy*dy);
                if (dist < r.speed) { explode(r.x, r.y, r.hue); return false; }
                r.x += (dx/dist) * r.speed; r.y += (dy/dist) * r.speed;
                ctx.beginPath(); ctx.arc(r.x, r.y, 3, 0, Math.PI*2);
                ctx.fillStyle = "hsla("+r.hue+",100%,75%,1)"; ctx.fill();
                ctx.beginPath(); ctx.arc(r.x, r.y, 7, 0, Math.PI*2);
                ctx.fillStyle = "hsla("+r.hue+",100%,75%,0.25)"; ctx.fill();
                return true;
            });
            particles = particles.filter(function(p) {
                p.x += p.vx; p.y += p.vy; p.vy += 0.07;
                p.vx *= 0.97; p.vy *= 0.97; p.alpha -= p.decay;
                if (p.alpha <= 0) return false;
                ctx.beginPath(); ctx.arc(p.x, p.y, 2.5, 0, Math.PI*2);
                ctx.fillStyle = "hsla("+p.hue+",100%,65%,"+p.alpha+")"; ctx.fill();
                return true;
            });
            count++;
            if (count % 20 === 0 && count < 200) addRocket();
            if (rockets.length > 0 || particles.length > 0) {
                rafId = requestAnimationFrame(draw);
            } else { canvas.remove(); }
        }
        rafId = requestAnimationFrame(draw);
        setTimeout(function() { cancelAnimationFrame(rafId); if (canvas.parentNode) canvas.remove(); }, 6000);
    }

    // Aqui genero globos flotando con HTML y CSS para una animacion mas suave.
    function runBalloons() {
        var colors = [
            ["#ff4d6d","#ff8fab"], ["#4dabf7","#a5d8ff"],
            ["#ffd43b","#ffec99"], ["#9775fa","#d0bfff"],
            ["#6ecb63","#b2f2bb"], ["#ff922b","#ffc078"]
        ];
        var style = document.createElement("style");
        style.textContent = [
            "@keyframes spFloat{0%{transform:translate(0,0) rotate(var(--r));opacity:1}100%{transform:translate(var(--dx),-115vh) rotate(calc(var(--r) + 18deg));opacity:0}}",
            ".sp-bwrap{position:fixed;pointer-events:none;z-index:99999;animation:spFloat var(--dur) ease-out forwards}",
            ".sp-ball{position:relative;width:var(--w);height:calc(var(--w) * 1.18);border-radius:50%;background:radial-gradient(circle at 38% 32%, var(--light) 0%, var(--dark) 65%)}",
            ".sp-ball::after{content:\"\";position:absolute;bottom:-9px;left:50%;transform:translateX(-50%);width:0;height:0;border-left:7px solid transparent;border-right:7px solid transparent;border-top:11px solid var(--dark)}",
            ".sp-shine{position:absolute;top:14%;left:18%;width:28%;height:22%;background:rgba(255,255,255,0.45);border-radius:50%;transform:rotate(-35deg)}",
            ".sp-string{position:absolute;top:calc(var(--w) * 1.18);left:calc(50% - 1px);width:2px;height:55px;background:rgba(0,0,0,0.18)}"
        ].join("");
        document.head.appendChild(style);
        for (var i = 0; i < 14; i++) {
            (function(i) {
                setTimeout(function() {
                    var pair = colors[Math.floor(Math.random() * colors.length)];
                    var w = 58 + Math.random() * 32;
                    var wrap = document.createElement("div");
                    wrap.className = "sp-bwrap";
                    wrap.style.cssText = [
                        "left:" + (Math.random() * 88 + 4) + "vw",
                        "bottom:-140px",
                        "--w:" + w + "px",
                        "--dark:" + pair[0],
                        "--light:" + pair[1],
                        "--r:" + (Math.random() * 18 - 9) + "deg",
                        "--dx:" + (Math.random() * 80 - 40) + "px",
                        "--dur:" + (5 + Math.random() * 3) + "s"
                    ].join(";");
                    var ball = document.createElement("div"); ball.className = "sp-ball";
                    var shine = document.createElement("div"); shine.className = "sp-shine";
                    var str = document.createElement("div"); str.className = "sp-string";
                    ball.appendChild(shine);
                    wrap.appendChild(ball);
                    wrap.appendChild(str);
                    document.body.appendChild(wrap);
                    wrap.addEventListener("animationend", function() { wrap.remove(); });
                }, i * 180);
            })(i);
        }
        setTimeout(function() { style.remove(); }, 16000);
    }

    // Esta ultima alternativa deja caer emojis festivos por la pantalla.
    function runEmoji() {
        var emojis = ["🎉","🎊","⭐","✨","🥳","🎈","💥","🌟","🎆","🎇"];
        var style = document.createElement("style");
        style.textContent = "@keyframes spEmojifall{0%{transform:translateY(-60px) rotate(var(--r));opacity:1}100%{transform:translateY(110vh) rotate(calc(var(--r) + var(--spin)));opacity:0}}.sp-emoji{position:fixed;top:0;pointer-events:none;z-index:99999;font-size:var(--sz);animation:spEmojifall var(--dur) ease-in forwards}";
        document.head.appendChild(style);
        for (var i = 0; i < 40; i++) {
            (function(i) {
                setTimeout(function() {
                    var el = document.createElement("div");
                    el.className = "sp-emoji";
                    el.textContent = emojis[Math.floor(Math.random() * emojis.length)];
                    el.style.cssText = [
                        "left:" + (Math.random() * 96 + 2) + "vw",
                        "--sz:" + (24 + Math.random() * 28) + "px",
                        "--r:" + (Math.random() * 40 - 20) + "deg",
                        "--spin:" + (Math.random() * 180 - 90) + "deg",
                        "--dur:" + (2.5 + Math.random() * 2.5) + "s"
                    ].join(";");
                    document.body.appendChild(el);
                    el.addEventListener("animationend", function() { el.remove(); });
                }, i * 120);
            })(i);
        }
        setTimeout(function() { style.remove(); }, 14000);
    }

    // Con esta utilidad creo un canvas de pantalla completa y sin eventos de raton.
    function makeCanvas() {
        var c = document.createElement("canvas");
        c.style.cssText = "position:fixed;top:0;left:0;width:100%;height:100%;pointer-events:none;z-index:99999";
        document.body.appendChild(c);
        c.width = window.innerWidth; c.height = window.innerHeight;
        return c;
    }
})();
</script>');
    }
}
