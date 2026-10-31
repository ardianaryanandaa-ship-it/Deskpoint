
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>404 - Halaman Tidak Ditemukan</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;

            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI",
                Roboto, Helvetica, Arial, sans-serif;

            background:
                radial-gradient(circle at 15% 20%,
                    rgba(99, 102, 241, 0.10),
                    transparent 28%),
                radial-gradient(circle at 85% 80%,
                    rgba(124, 58, 237, 0.10),
                    transparent 30%),
                linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);

            color: #1e293b;

            overflow: hidden;
        }

        /* =========================
           MAIN CONTAINER
        ========================= */

        .error-container {
            width: 100%;
            max-width: 700px;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        /* =========================
           ANIMATED ILLUSTRATION
        ========================= */

        .illustration {
            position: relative;

            width: 220px;
            height: 180px;

            margin: 0 auto 5px;

            animation: floating 4s ease-in-out infinite;
        }

        @keyframes floating {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .illustration svg {
            width: 100%;
            height: 100%;
            overflow: visible;
        }

        /* Main document */

        .document {
            animation: documentMove 3.5s ease-in-out infinite;
            transform-origin: center;
        }

        @keyframes documentMove {

            0%,
            100% {
                transform: rotate(0deg);
            }

            50% {
                transform: rotate(-3deg);
            }
        }

        /* Magnifying glass */

        .magnifier {
            animation: magnifierMove 3s ease-in-out infinite;
            transform-origin: 145px 105px;
        }

        @keyframes magnifierMove {

            0%,
            100% {
                transform: translate(0, 0) rotate(0deg);
            }

            50% {
                transform: translate(7px, -6px) rotate(5deg);
            }
        }

        /* Sparkles */

        .sparkle {
            animation: sparkle 2.5s ease-in-out infinite;
            transform-origin: center;
        }

        .sparkle-2 {
            animation-delay: .7s;
        }

        .sparkle-3 {
            animation-delay: 1.3s;
        }

        @keyframes sparkle {

            0%,
            100% {
                opacity: .35;
                transform: scale(.75) rotate(0deg);
            }

            50% {
                opacity: 1;
                transform: scale(1.15) rotate(15deg);
            }
        }

        /* =========================
           404
        ========================= */

        .error-code {
            font-size: clamp(100px, 20vw, 180px);
            line-height: 0.9;
            font-weight: 800;
            letter-spacing: -8px;

            background: linear-gradient(135deg, #4f46e5, #7c3aed);

            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;

            background-clip: text;

            margin-bottom: 25px;

            filter: drop-shadow(
                0 10px 20px rgba(79, 70, 229, 0.10)
            );
        }

        .error-title {
            font-size: 30px;
            font-weight: 700;

            color: #0f172a;

            margin-bottom: 12px;
        }

        .error-message {
            max-width: 500px;

            margin: 0 auto 30px;

            font-size: 16px;
            line-height: 1.7;

            color: #64748b;
        }

        /* =========================
           BUTTON
        ========================= */

        .button-group {
            display: flex;

            justify-content: center;

            gap: 12px;

            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;

            align-items: center;
            justify-content: center;

            gap: 8px;

            padding: 12px 22px;

            border-radius: 10px;

            font-size: 14px;
            font-weight: 600;

            text-decoration: none;

            transition: all 0.25s ease;

            cursor: pointer;
        }

        .btn-primary {
            color: #ffffff;

            background:
                linear-gradient(
                    135deg,
                    #4f46e5,
                    #6366f1
                );

            box-shadow:
                0 6px 15px rgba(79, 70, 229, 0.25);
        }

        .btn-primary:hover {
            background:
                linear-gradient(
                    135deg,
                    #4338ca,
                    #4f46e5
                );

            transform: translateY(-3px);

            box-shadow:
                0 10px 25px rgba(79, 70, 229, 0.30);
        }

        .btn-secondary {
            color: #334155;

            background: #ffffff;

            border: 1px solid #e2e8f0;
        }

        .btn-secondary:hover {
            background: #f8fafc;

            border-color: #cbd5e1;

            transform: translateY(-3px);

            box-shadow:
                0 8px 20px rgba(15, 23, 42, 0.07);
        }

        /* =========================
           FOOTER
        ========================= */

        .footer {
            margin-top: 45px;

            font-size: 13px;

            color: #94a3b8;
        }

        /* =========================
           DECORATIVE BACKGROUND
        ========================= */

        .circle {
            position: fixed;

            border-radius: 50%;

            z-index: 0;

            pointer-events: none;

            filter: blur(1px);

            animation: circleFloat 8s ease-in-out infinite;
        }

        .circle-one {
            width: 250px;
            height: 250px;

            top: -100px;
            left: -100px;

            background:
                radial-gradient(
                    circle,
                    rgba(99, 102, 241, 0.12),
                    transparent 70%
                );
        }

        .circle-two {
            width: 300px;
            height: 300px;

            right: -130px;
            bottom: -130px;

            background:
                radial-gradient(
                    circle,
                    rgba(124, 58, 237, 0.12),
                    transparent 70%
                );

            animation-delay: -3s;
        }

        @keyframes circleFloat {

            0%,
            100% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(15px, -15px);
            }
        }

        /* =========================
           MOBILE
        ========================= */

        @media (max-width: 600px) {

            body {
                padding: 15px;
            }

            .illustration {
                width: 190px;
                height: 155px;

                margin-bottom: 5px;
            }

            .error-code {
                letter-spacing: -5px;

                margin-bottom: 20px;
            }

            .error-title {
                font-size: 24px;
            }

            .error-message {
                font-size: 14px;
            }

            .button-group {
                flex-direction: column;

                width: 100%;
            }

            .btn {
                width: 100%;
            }

            .footer {
                margin-top: 30px;
            }
        }
    </style>
</head>

<body>

    <!-- Background -->
    <div class="circle circle-one"></div>
    <div class="circle circle-two"></div>

    <main class="error-container">

        <!-- Animated Illustration -->
        <div class="illustration">

            <svg viewBox="0 0 220 180"
                 xmlns="http://www.w3.org/2000/svg">

                <!-- Glow -->
                <defs>

                    <radialGradient id="glow">
                        <stop offset="0%"
                              stop-color="#6366f1"
                              stop-opacity=".25" />

                        <stop offset="100%"
                              stop-color="#6366f1"
                              stop-opacity="0" />
                    </radialGradient>

                    <linearGradient id="paper"
                                    x1="0"
                                    y1="0"
                                    x2="1"
                                    y2="1">

                        <stop offset="0%"
                              stop-color="#ffffff" />

                        <stop offset="100%"
                              stop-color="#eef2ff" />

                    </linearGradient>

                    <linearGradient id="glass"
                                    x1="0"
                                    y1="0"
                                    x2="1"
                                    y2="1">

                        <stop offset="0%"
                              stop-color="#818cf8" />

                        <stop offset="100%"
                              stop-color="#4f46e5" />

                    </linearGradient>

                    <filter id="shadow">

                        <feDropShadow
                            dx="0"
                            dy="8"
                            stdDeviation="7"
                            flood-color="#4f46e5"
                            flood-opacity=".15" />

                    </filter>

                </defs>

                <!-- Glow Circle -->
                <circle
                    cx="110"
                    cy="95"
                    r="78"
                    fill="url(#glow)" />

                <!-- Document -->
                <g class="document"
                   filter="url(#shadow)">

                    <rect
                        x="53"
                        y="25"
                        width="92"
                        height="120"
                        rx="12"
                        fill="url(#paper)"
                        stroke="#e0e7ff"
                        stroke-width="2" />

                    <!-- Fold -->
                    <path
                        d="M115 25 L145 55 L115 55 Z"
                        fill="#e0e7ff" />

                    <!-- Lines -->
                    <rect
                        x="72"
                        y="72"
                        width="50"
                        height="6"
                        rx="3"
                        fill="#c7d2fe" />

                    <rect
                        x="72"
                        y="87"
                        width="38"
                        height="6"
                        rx="3"
                        fill="#c7d2fe" />

                    <rect
                        x="72"
                        y="102"
                        width="45"
                        height="6"
                        rx="3"
                        fill="#c7d2fe" />

                    <!-- Question -->
                    <text
                        x="98"
                        y="133"
                        text-anchor="middle"
                        font-size="20"
                        font-weight="700"
                        fill="#6366f1">
                        ?
                    </text>

                </g>

                <!-- Magnifying Glass -->
                <g class="magnifier">

                    <!-- Glass -->
                    <circle
                        cx="145"
                        cy="105"
                        r="27"
                        fill="rgba(255,255,255,.75)"
                        stroke="url(#glass)"
                        stroke-width="8" />

                    <!-- Reflection -->
                    <path
                        d="M130 94
                           C134 87 141 83 148 83"
                        fill="none"
                        stroke="#ffffff"
                        stroke-width="4"
                        stroke-linecap="round"
                        opacity=".8" />

                    <!-- Handle -->
                    <line
                        x1="165"
                        y1="126"
                        x2="187"
                        y2="148"
                        stroke="#4f46e5"
                        stroke-width="9"
                        stroke-linecap="round" />

                </g>

                <!-- Sparkle 1 -->
                <g class="sparkle">

                    <path
                        d="M39 51
                           L42 59
                           L50 62
                           L42 65
                           L39 73
                           L36 65
                           L28 62
                           L36 59 Z"
                        fill="#818cf8" />

                </g>

                <!-- Sparkle 2 -->
                <g class="sparkle sparkle-2">

                    <path
                        d="M178 42
                           L180 48
                           L186 50
                           L180 52
                           L178 58
                           L176 52
                           L170 50
                           L176 48 Z"
                        fill="#a78bfa" />

                </g>

                <!-- Sparkle 3 -->
                <g class="sparkle sparkle-3">

                    <path
                        d="M177 135
                           L180 143
                           L188 146
                           L180 149
                           L177 157
                           L174 149
                           L166 146
                           L174 143 Z"
                        fill="#6366f1" />

                </g>

            </svg>

        </div>

        <!-- 404 -->
        <div class="error-code">
            404
        </div>

        <!-- Title -->
        <h1 class="error-title">
            Halaman Tidak Ditemukan Mas
        </h1>

        <!-- Message -->
        <p class="error-message">
            Maaf, halaman yang Anda cari tidak dapat ditemukan.
            Kemungkinan halaman telah dipindahkan, dihapus,
            atau alamat yang Anda masukkan tidak benar.
        </p>

        <!-- Buttons -->
        <div class="button-group">

            <a href="<?= base_url('/') ?>"
               class="btn btn-primary">

                ← Kembali ke Beranda

            </a>

            <a href="javascript:history.back()"
               class="btn btn-secondary">

                Kembali

            </a>

        </div>

        <!-- Footer -->
        <div class="footer">

            &copy; <?= date('Y') ?>

            <?= esc(config('App')->appName ?? 'Application') ?>

        </div>

    </main>

</body>

</html>