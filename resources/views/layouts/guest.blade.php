<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'UTP | Control de Profesores') }}</title>

    <!-- Fuentes -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Estilos -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Figtree', sans-serif;
            color: #263326;
        }

        /* FONDO GENERAL */
        .fondo-login {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 35px 18px;
            position: relative;
            overflow: hidden;
            background:
                radial-gradient(circle at 10% 15%, rgba(133, 157, 99, 0.20), transparent 30%),
                radial-gradient(circle at 90% 85%, rgba(101, 125, 67, 0.16), transparent 32%),
                linear-gradient(135deg, #edf3e6 0%, #e2edda 50%, #dce8d2 100%);
        }

        /* DECORACIONES */
        .decoracion {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            filter: blur(80px);
        }

        .decoracion-superior {
            width: 380px;
            height: 380px;
            top: -180px;
            left: -130px;
            background: rgba(101, 125, 67, 0.20);
        }

        .decoracion-inferior {
            width: 420px;
            height: 420px;
            bottom: -200px;
            right: -150px;
            background: rgba(164, 181, 139, 0.30);
        }

        /* LOGOTIPO */
        .logo-login {
            position: relative;
            z-index: 2;
            margin-bottom: 20px;
        }

        .logo-login img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            display: block;
            filter: drop-shadow(0 5px 8px rgba(35, 55, 30, 0.12));
        }

        /* TARJETA DEL FORMULARIO */
        .formulario-login {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 460px;
            padding: 38px 40px;
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid rgba(101, 125, 67, 0.16);
            border-radius: 20px;
            box-shadow:
                0 25px 60px rgba(42, 61, 35, 0.10),
                0 5px 15px rgba(42, 61, 35, 0.05);
        }

        /* ENCABEZADO */
        .encabezado-login {
            margin-bottom: 30px;
            text-align: left;
        }

        .encabezado-login .etiqueta {
            display: inline-block;
            margin-bottom: 10px;
            color: #718653;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .encabezado-login h2 {
            margin: 0;
            color: #314a2e;
            font-size: 27px;
            line-height: 1.25;
            font-weight: 700;
            letter-spacing: -0.7px;
        }

        .encabezado-login .subtitulo {
            margin-top: 9px;
            color: #879080;
            font-size: 13px;
            line-height: 1.6;
        }

        .linea-acento {
            width: 48px;
            height: 4px;
            margin-top: 17px;
            border-radius: 10px;
            background: #657d43;
        }

        /* ETIQUETAS */
        .formulario-login label {
            color: #394735 !important;
            font-size: 13px !important;
            font-weight: 600 !important;
        }

        /* CAMPOS */
        .formulario-login input[type="email"],
        .formulario-login input[type="password"],
        .formulario-login input[type="text"] {
            width: 100%;
            min-height: 46px;
            padding: 11px 14px;
            border: 1px solid #dce4d5 !important;
            border-radius: 9px !important;
            background: #f9fbf7 !important;
            color: #344330 !important;
            font-size: 14px;
            transition: all 0.2s ease;
            box-shadow: none !important;
        }

        .formulario-login input:focus {
            outline: none !important;
            border-color: #829866 !important;
            background: #ffffff !important;
            box-shadow: 0 0 0 3px rgba(101, 125, 67, 0.12) !important;
        }

        .formulario-login input::placeholder {
            color: #a6afa0;
        }

        /* ENLACES */
        .formulario-login a {
            color: #657d43;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .formulario-login a:hover {
            color: #40562d;
        }

        /* CHECKBOX */
        .formulario-login input[type="checkbox"] {
            accent-color: #657d43;
        }

        /* BOTÓN */
        .formulario-login button[type="submit"] {
            min-height: 45px;
            border-radius: 9px;
            font-weight: 700;
            letter-spacing: 0.5px;
            box-shadow: 0 5px 12px rgba(101, 125, 67, 0.18);
            transition: all 0.25s ease;
        }

        .formulario-login button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(101, 125, 67, 0.25);
        }

        /* PIE DE PÁGINA */
        .pie-login {
            position: relative;
            z-index: 2;
            margin-top: 22px;
            color: #77866d;
            font-size: 11px;
            letter-spacing: 0.4px;
            text-align: center;
        }

        @media (max-width: 480px) {
            .formulario-login {
                padding: 30px 23px;
                border-radius: 16px;
            }

            .logo-login img {
                width: 85px;
                height: 85px;
            }

            .encabezado-login h2 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body class="font-sans antialiased">

    <div class="fondo-login">

        <!-- Decoración -->
        <div class="decoracion decoracion-superior"></div>
        <div class="decoracion decoracion-inferior"></div>

        <!-- Logotipo -->
        <div class="logo-login">
            <a href="/">
                <img
                    src="{{ asset('images/utp.png') }}"
                    alt="Logo Universidad Tecnológica de Puebla"
                >
            </a>
        </div>

        <!-- Tarjeta de inicio de sesión -->
        <div class="formulario-login">

            <div class="encabezado-login">
                <span class="etiqueta">Universidad Tecnológica de Puebla</span>

                <h2>Control de Profesores</h2>

                <p class="subtitulo">
                    Accede para administrar y consultar información académica
                </p>

                <div class="linea-acento"></div>
            </div>

            {{ $slot }}

        </div>

        <!-- Pie de página -->
        <div class="pie-login">
            Universidad Tecnológica de Puebla - Sistema de Control Docente
        </div>

    </div>

</body>
</html>
