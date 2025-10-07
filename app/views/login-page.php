<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neumorphic Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        
        html, body {
            font-family: 'Inter', sans-serif;
        }

        /* Animated gradient background */
        @keyframes subtleGradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        body {
            background: linear-gradient(-45deg, #e6e6e6, #f0f0f0, #e6e6e6, #f8f8f8);
            background-size: 400% 400%;
            animation: subtleGradientMove 15s ease infinite;
            color: #616161;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        /* Blurry orange rising sun light source */
        body::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 1000px;
            height: 1000px;
            background: radial-gradient(circle at 10% 90%, rgba(255, 120, 0, 0.4), transparent 70%);
            filter: blur(120px);
            z-index: 0;
            opacity: 0.8;
            pointer-events: none;
        }

        /* Subtle secondary light source */
        body::after {
            content: '';
            position: absolute;
            top: 15%;
            right: 15%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.5), transparent);
            filter: blur(80px);
            z-index: 0;
            opacity: 0.8;
            pointer-events: none;
        }

        /* General soft-ui class for all main containers and elements */
        .soft-ui {
            border-radius: 1.5rem;
            background: #e6e6e6;
            box-shadow: 6px 6px 12px #c9c9c9,
                        -6px -6px 12px #ffffff;
            transition: all 0.3s ease-in-out;
            position: relative;
            z-index: 1; /* Ensure UI is above the gradient */
        }

        /* Inset effect for clickable elements, making them look pressed */
        .soft-ui-inset {
            box-shadow: inset 5px 5px 10px #c9c9c9,
                        inset -5px -5px 10px #ffffff;
        }

        /* Hover effect for buttons and links to show they are interactive */
        .soft-ui-hover:hover {
            box-shadow: 4px 4px 8px #c9c9c9,
                        -4px -4px 8px #ffffff;
            transform: translateY(-2px);
        }

        /* Active/click effect to simulate a press */
        .soft-ui-active:active {
            box-shadow: inset 5px 5px 10px #c9c9c9,
                        inset -5px -5px 10px #ffffff;
            transform: translateY(0);
        }

        /* Primary red button with a soft-ui look */
        .soft-ui-red {
            background-color: #ff6a6a;
            color: white;
            box-shadow: 6px 6px 12px #d65959,
                        -6px -6px 12px #ff7b7b;
        }

        /* Text shadow for subtle depth */
        .text-shadow {
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
        
        /* Interactive text for links */
        .soft-ui-link:hover {
            color: #4a4a4a;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container mx-auto max-w-sm">
        <div class="soft-ui p-8 rounded-2xl flex flex-col items-center">
            <h1 class="text-4xl font-semibold tracking-wider text-gray-700 text-shadow mb-8">
                Login
            </h1>
             <!-- ✅ Error handling here -->
            <?php if (isset($error)): ?>
                <div class="mb-6 w-full p-4 rounded-xl bg-red-100 text-red-700 text-center font-semibold shadow">
                    <?= $error ?>
                </div>
            <?php endif; ?>
        
            <form action="<?= site_url('login') ?>" method="POST" class="w-full">
                <div class="mb-6">
                    <label for="email" class="block text-gray-500 text-sm font-semibold mb-2">Email Address</label>
                    <div class="soft-ui-inset rounded-xl p-2">
                        <input type="email" id="email" name="email" placeholder="you@example.com" class="w-full bg-transparent outline-none text-gray-700 placeholder-gray-400 px-2 py-1">
                    </div>
                </div>
                <div class="mb-8">
                    <label for="password" class="block text-gray-500 text-sm font-semibold mb-2">Password</label>
                    <div class="soft-ui-inset rounded-xl p-2">
                        <input type="password" id="password" name="password" placeholder="••••••••" class="w-full bg-transparent outline-none text-gray-700 placeholder-gray-400 px-2 py-1">
                    </div>
                </div>
                <div class="flex gap-4">
                <button type="submit" 
                        class="flex-1 font-semibold text-lg px-8 py-4 rounded-xl soft-ui soft-ui-red soft-ui-hover soft-ui-active">
                    Log In
                </button>

                <a href="<?=site_url('landing-page');?>"
                    class="flex-1 text-center font-semibold text-lg px-8 py-4 rounded-xl soft-ui soft-ui-hover text-gray-700">
                    BACK
                </a>
                </div>
            </form>
            <div class="mt-6 flex flex-col items-center space-y-2">
                <p class="text-gray-500 text-sm">
                    Don't have an account? 
                    <a href="<?= site_url('signup'); ?>" class="font-semibold soft-ui-link">Sign Up</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
