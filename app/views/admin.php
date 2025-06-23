<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--link bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>Admin sidebar</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="public/css/admin.css">
</head>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container-admin">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="LOGO" id="LOGO">
                            <h1><span class="Best">BEST</span>PRICE</h1>
                        </span><br><br>
                        <span class="LOGO2" id="LOGO2">
                            <h1><span class="Best" style="font-size: 26px;">BEST</span>
                                <h1>
                                    <h1 style="font-size: 23px;">PRICE</h1>
                        </span>

                    </a>
                </li>

                <li>
                    <a href="admin">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="gestao-produto">
                        <span class="icon">
                            <ion-icon name="bag-outline"></ion-icon>
                        </span>
                        <span class="title">Editar Catalogo </span>
                    </a>
                </li>

                <li>
                    <a href="estoque">
                        <span class="icon">
                            <ion-icon name="archive-outline"></ion-icon>
                        </span>
                        <span class="title">Gestão de Estoque</span>
                    </a>
                </li>

                <li>
                    <a href="categoria">
                        <span class="icon">
                            <ion-icon name="layers-outline"></ion-icon>
                        </span>
                        <span class="title">Gestão de Categorias</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="settings-outline"></ion-icon>
                        </span>
                        <span class="title">Configuração</span>
                    </a>
                </li>
                <li>
                    <a href="logout">
                        <span class="icon">
                            <ion-icon name="exit-outline"></ion-icon>
                        </span>
                        <span class="title">Logout</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                <div class="search">
                    <label>
                        <input type="text" placeholder="Search here">
                    </label>
                </div>

                <a href="perfil">
                    <div class="user">
                        <img src="public/img/person-outline.jpg" alt="">
                    </div>
                </a>
            </div>


            <!-- =========== Scripts =========  -->
            <script>
                // add hovered class to selected list item
                let list = document.querySelectorAll(".navigation li");

                function activeLink() {
                    list.forEach((item) => {
                        item.classList.remove("hovered");
                    });
                    this.classList.add("hovered");
                }

                list.forEach((item) => item.addEventListener("mouseover", activeLink));

                // Menu Toggle
                let toggle = document.querySelector(".toggle");
                let navigation = document.querySelector(".navigation");
                let main = document.querySelector(".main");

                toggle.onclick = function () {
                    navigation.classList.toggle("active");
                    main.classList.toggle("active");

                };
            </script>

            <!-- ====== ionicons ======= -->
            <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
            <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>
