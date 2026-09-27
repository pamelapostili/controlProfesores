<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Control de Profesores UTP')
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet"
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>

        :root {

            --verde: #6f7e49;

            --verde-oscuro: #56643a;

            --verde-claro: #edf2df;

            --fondo: #f6f8f3;

            --texto: #1e2a1c;

            --gris: #71806e;

            --borde: #e4e9df;
        }


        * {
            box-sizing: border-box;
        }


        body {

            background: var(--fondo);

            color: var(--texto);

            font-family: 'Inter', sans-serif;
        }


        .navbar {

            background: white;

            border-bottom:
                1px solid var(--borde);
        }


        .logo {

            width: 42px;

            height: 42px;

            border-radius: 13px;

            display: flex;

            align-items: center;

            justify-content: center;

            background: var(--verde);

            color: white;
        }


        .brand {

            font-weight: 800;

            color: var(--texto);

            text-decoration: none;
        }


        .hero {

            background:
                linear-gradient(
                    135deg,
                    #ffffff,
                    #f2f6e9
                );

            border:
                1px solid var(--borde);

            border-radius: 28px;

            padding: 40px;
        }


        .hero h1 {

            font-weight: 800;

            letter-spacing: -1px;
        }


        .hero p {

            color: var(--gris);
        }


        .search-box {

            background: white;

            border:
                1px solid var(--borde);

            border-radius: 18px;

            padding: 8px;
        }


        .teacher-card {

            position: relative;

            height: 100%;

            background: white;

            border:
                1px solid var(--borde);

            border-radius: 24px;

            overflow: hidden;

            transition: .2s;
        }


        .teacher-card:hover {

            transform: translateY(-4px);

            box-shadow:
                0 18px 45px
                rgba(42,57,35,.10);
        }


        .card-top {

            padding: 24px;
        }


        .avatar {

            width: 78px;

            height: 78px;

            object-fit: cover;

            border-radius: 22px;
        }


        .teacher-name {

            font-size: 1.05rem;

            font-weight: 800;
        }


        .department {

            color: var(--gris);

            font-size: .82rem;
        }


        .status-pill {

            position: absolute;

            top: 18px;

            right: 18px;

            padding: 7px 11px;

            border-radius: 999px;

            font-size: .7rem;

            font-weight: 700;
        }


        .status-class {

            color: #b45b27;

            background: #fff1e8;
        }


        .status-free {

            color: #3d7c55;

            background: #eaf7ee;
        }


        .status-food {

            color: #a46a18;

            background: #fff5dc;
        }


        .status-coming {

            color: #4d6da8;

            background: #edf2ff;
        }


        .status-gone {

            color: #7b8087;

            background: #f0f1f3;
        }


        .status-near {

            color: #557d78;

            background: #e9f6f3;
        }


        .status-building {

            color: #765a9b;

            background: #f3edfb;
        }


        .meta-row {

            margin: 0 24px 20px;

            padding: 14px;

            border-radius: 16px;

            background: #f8faf6;
        }


        .meta-label {

            color: var(--gris);

            font-size: .68rem;

            text-transform: uppercase;

            font-weight: 700;
        }


        .meta-value {

            font-size: 1rem;

            font-weight: 800;
        }


        .location {

            color: var(--gris);

            font-size: .8rem;
        }


        .card-actions {

            border-top:
                1px solid var(--borde);

            padding: 12px 16px;

            display: flex;

            justify-content: space-between;

            align-items: center;
        }


        .btn-brand {

            background: var(--verde);

            color: white;

            border: 0;

            font-weight: 700;
        }


        .btn-brand:hover {

            background: var(--verde-oscuro);

            color: white;
        }


        .btn-icon {

            width: 40px;

            height: 40px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 12px;

            border: 1px solid var(--borde);

            color: var(--gris);

            background: white;
        }


        .btn-icon:hover {

            color: var(--verde);

            background: var(--verde-claro);
        }


        .detail-box {

            background: white;

            border:
                1px solid var(--borde);

            border-radius: 24px;

            padding: 28px;
        }


        .detail-avatar {

            width: 110px;

            height: 110px;

            object-fit: cover;

            border-radius: 30px;
        }


        .schedule {

            border-bottom:
                1px solid var(--borde);

            padding: 18px 0;
        }


        .schedule:last-child {

            border-bottom: 0;
        }


        .day {

            display: inline-block;

            background: var(--verde-claro);

            color: var(--verde-oscuro);

            border-radius: 10px;

            padding: 7px 10px;

            font-size: .75rem;

            font-weight: 800;
        }

    </style>

</head>


<body>


<nav class="navbar navbar-expand-lg">

    <div class="container py-2">

        <a
            href="{{ route('profesores.index') }}"
            class="brand d-flex align-items-center gap-2"
        >

            <span class="logo">

                <i class="bi bi-mortarboard-fill"></i>

            </span>

            Control de Profesores UTP

        </a>


        <button
            class="navbar-toggler"
            data-bs-toggle="collapse"
            data-bs-target="#menu"
        >

            <i class="bi bi-list"></i>

        </button>


        <div
            class="collapse navbar-collapse"
            id="menu"
        >

            <div class="navbar-nav ms-auto">

                <a
                    class="nav-link"
                    href="{{ route('profesores.index') }}"
                >

                    <i class="bi bi-people"></i>

                    Profesores

                </a>

                <a
                    class="nav-link"
                    href="#"
                >

                    <i class="bi bi-info-circle"></i>

                    Ayuda

                </a>

            </div>

        </div>

    </div>

</nav>


<main class="container py-5">

    @yield('content')

</main>


<script
src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


</body>

</html>