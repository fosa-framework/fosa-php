<!DOCTYPE html>
<html lang="<?php $this->get_locale(); ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fosa - <?php $this->render_locale('title'); ?></title>
    <meta name="description" content="<?php $this->render_locale('description'); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php $this->assets('favicon', 'apple-touch-icon.png'); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php $this->assets('favicon', 'favicon-32x32.png'); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php $this->assets('favicon', 'favicon-16x16.png'); ?>">
    <link rel="manifest" href="<?php $this->assets('favicon', 'site.webmanifest'); ?>">
    <link rel="mask-icon" href="<?php $this->assets('favicon', 'safari-pinned-tab.svg'); ?>" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        :root {
            --primary: #6c1464;
            --secondary: #e43c34;
            --title: #24252a;
            --text: rgba(0,0,0,0.75);
        }
        body {
            position: relative;
            font-family: 'Nunito', sans-serif;
            padding: 0;
            margin: 0;
            min-height: 100vh;
            background-color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            padding: 30px;
        }
        header img {
            width: 200px;
            height: auto;
            margin-bottom: 30px;
        }
        .app-name {
            font-weight: 900;
            color: var(--secondary);
            display: flex;
            align-items: center;
        }
        img {
            margin-right: 15px;
        }
        .title {
            color: var(--primary);
            font-size: 3rem;
        }
        .description {
            color: var(--text);
            max-width: 550px;
        }
        code {
            padding: 5px 10px;
            margin-left: 5px;
            margin-right: 5px;
            border-radius: 5px;
            background-color: var(--title);
            color: var(--secondary);
        }
        .cards {
            margin-top: 50px;
            display: flex;
            align-items: center;
            justify-content: space-around;
            flex-wrap: wrap;
        }
        .card {
            padding: 10px 20px 10px 20px;
            background-color: var(--primary);
            color: #ffffff;
            border-radius: 5px;
            font-size: .9rem;
            margin-bottom: 15px;
        }
        footer {
            margin-top: 50px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        a {
            color: var(--title);
            font-size: .9rem;
            text-decoration: none;
            color: var(--primary);
        }
        i {
            margin-right: 10px;
        }
        small {
            color: var(--text);
        }
    </style>
</head>
<body>
<div class="container">
    <header>
        <img src="<?php $this->assets('images', 'Fosa.png'); ?>" alt="Fosa">
        <h3 class="app-name">
            Fosa Framework Beta 0.1
        </h3>
    </header>
    <main>
        <h1 class="title"><?php $this->render_locale('main.title') ?></h1>
        <p class="description"><?php $this->render_locale('main.content'); ?></p>
        <div class="cards">
            <div class="card">
                <i class="fas fa-globe"></i>
                <span><?php $this->render_locale('features.web-app'); ?></span>
            </div>
            <div class="card">
                <i class="fas fa-cogs"></i>
                <span><?php $this->render_locale('features.rest-api'); ?></span>
            </div>
            <div class="card">
                <i class="fas fa-box"></i>
                <span><?php $this->render_locale('features.static-website') ?></span>
            </div>
        </div>
    </main>
    <footer>
        <a href="https://github.com/fosa-framework" target="_blank" rel="noreferrer"><i class="fab fa-github"></i><?php $this->render_locale('github') ?></a>
        <a href="/?lang=en-EN"><i class="fas fa-flag"></i>English</a>
        <a href="/?lang=fr-FR"><i class="fas fa-flag"></i>Français</a>
    </footer>
</div>
</body>
</html>