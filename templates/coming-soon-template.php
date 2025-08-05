<?php
$options = get_option('smp_settings');
$logo = isset($options['logo']) ? $options['logo'] : '';
$message = isset($options['maintenance_text']) ? $options['maintenance_text'] : 'We’ll be back soon!';
$target = isset($options['smp_countdown']) ? $options['smp_countdown'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Maintenance</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            --bg-color: #f9fafb;
            --text-color: #1f2937;
            --accent-color: #3b82f6;
            --font: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: var(--font);
            background-color: var(--bg-color);
            color: var(--text-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            text-align: center;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            width: 100%;
        }

        img.logo {
            max-width: 180px;
            margin: 0 auto 30px;
            display: block;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--accent-color);
        }

        p {
            font-size: 1.1rem;
            line-height: 1.6;
        }

        #countdown {
            font-size: 1.3rem;
            margin-top: 25px;
            font-weight: bold;
            color: var(--text-color);
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 1.5rem;
            }

            p, #countdown {
                font-size: 1rem;
            }

            img.logo {
                max-width: 140px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($logo): ?>
            <img src="<?php echo esc_url($logo); ?>" alt="Logo" class="logo" />
        <?php endif; ?>

        <h1>We'll be back soon!</h1>
        <p><?php echo esc_html($message); ?></p>

        <?php if ($target): ?>
            <div id="countdown"></div>
        <?php endif; ?>
    </div>

    <?php if ($target): ?>
    <script>
        (function(){
            const countdownElement = document.getElementById('countdown');
            const targetDate = new Date("<?php echo esc_js($target); ?>").getTime();

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = targetDate - now;

                if (distance <= 0) {
                    countdownElement.innerHTML = "We're back!";
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                countdownElement.innerHTML = 
                    days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        })();
    </script>
    <?php endif; ?>
</body>
</html>
