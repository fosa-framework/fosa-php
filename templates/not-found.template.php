<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fosa - Template not found</title>
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
            --title: rgba(255,255,255,1);
            --text: rgba(255,255,255,0.75);
        }
        body {
            position: relative;
            font-family: 'Nunito', sans-serif;
            padding: 0;
            margin: 0;
            min-width: 100vh;
            background-color: var(--primary);=
        }
        .container {
            max-width: 650px;
            margin-left: auto;
            margin-right: auto;
            padding-top: 150px;
            padding-bottom: 150px;
        }
        .app-name {
            font-weight: 900;
            color: #ffffff;
            display: flex;
            align-items: center;
        }
        img {
            margin-right: 15px;
        }
        .error {
            color: var(--title);
            font-size: 3rem;
        }
        .description {
            color: var(--text);
        }
        code {
            padding: 5px 10px;
            margin-left: 5px;
            margin-right: 5px;
            border-radius: 5px;
            background-color: var(--title);
            color: var(--secondary);
        }
        footer {
            margin-top: 50px;
        }
        a {
            color: var(--title);
            font-size: .9rem;
            text-decoration: none;
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
        <h3 class="app-name">
            <img src="<?php $this->assets('favicon', 'favicon.ico'); ?>" alt="Fosa">
            Fosa App
        </h3>
    </header>
    <main>
        <h1 class="error">Error: Template not found</h1>
        <p class="description">The template<code><?php echo $data['template']; ?></code>you are trying to render cannot be found in directory <code>/templates</code>.</p>
    </main>
    <footer>
        <a href="#" target="_blank" rel="noreferrer"><i class="fab fa-github"></i>Fosa PHP Framework beta 0.1 2022</a>
    </footer>
</div>
</body>
</html>