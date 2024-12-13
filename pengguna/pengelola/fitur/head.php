<?php include 'nama_halaman.php'; ?>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/gereja/logo.jpg?v=<?= time(); ?>" />
    <link rel="icon" type="image/png" href="../../assets/img/gereja/logo.jpg?v=<?= time(); ?>" />
    <title><?= $page_title ?> | Gereja Emaus Liliba</title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700?v=<?= time(); ?>" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="../../assets/css/nucleo-icons.css?v=<?= time(); ?>" rel="stylesheet" />
    <link href="../../assets/css/nucleo-svg.css?v=<?= time(); ?>" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="../../assets/css/nucleo-svg.css?v=<?= time(); ?>" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="../../assets/css/soft-ui-dashboard.css?v=1.0.7?v=<?= time(); ?>" rel="stylesheet" />
    <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
    <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js?v=<?= time(); ?>">
    </script>

    <?php if ($page_title == "Profile") { ?>
        <!-- Bootstrap CSS -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css?v=<?= time(); ?>"
            rel="stylesheet">
        <!-- Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js?v=<?= time(); ?>"></script>
        <link href="../../assets/img/sma4/logo2.jpg" rel="icon" />
        <!-- Fonts and icons -->
        <script src="../../assets/js/plugin/webfont/webfont.min.js?v=<?= time(); ?>"></script>
    <?php } ?>
</head>