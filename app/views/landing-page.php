<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
    html, body { font-family: 'Inter', sans-serif; }

    @keyframes subtleGradientMove {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    body {
      background: linear-gradient(-45deg, #e6e6e6, #f0f0f0, #e6e6e6, #f8f8f8);
      background-size: 400% 400%;
      animation: subtleGradientMove 15s ease infinite;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;
      position: relative;
      overflow: hidden;
    }
    body::before {
      content: '';
      position: absolute;
      bottom: 0; left: 0;
      width: 1000px; height: 1000px;
      background: radial-gradient(circle at 10% 90%, rgba(255, 120, 0, 0.4), transparent 70%);
      filter: blur(120px); opacity: 0.8; z-index: 0;
    }
    .soft-ui {
      border-radius: 1.5rem;
      background: #e6e6e6;
      box-shadow: 6px 6px 12px #c9c9c9,
                  -6px -6px 12px #ffffff;
      transition: all 0.3s ease-in-out;
      position: relative;
      z-index: 1;
    }
    .soft-ui-hover:hover {
      transform: translateY(-2px);
      box-shadow: 4px 4px 8px #c9c9c9,
                  -4px -4px 8px #ffffff;
    }
    .soft-ui-red {
      background-color: #ff6a6a;
      color: white;
      box-shadow: 6px 6px 12px #d65959,
                  -6px -6px 12px #ff7b7b;
    }
  </style>
</head>
<body>
  <div class="soft-ui max-w-2xl w-full p-12 text-center">
    <h1 class="text-4xl font-bold text-gray-700 mb-4">Welcome to Our System</h1>
    <p class="text-lg text-gray-600 mb-8">
      Manage your records with ease and efficiency.
    </p>

    <div class="flex justify-center gap-6">
      <a href="<?=site_url('login');?>"
         class="soft-ui soft-ui-hover px-8 py-3 rounded-lg font-bold text-gray-700 text-lg">
        LOGIN
      </a>
      <a href="<?=site_url('signup');?>"
         class="soft-ui soft-ui-red soft-ui-hover px-8 py-3 rounded-lg font-bold text-white text-lg">
        REGISTER
      </a>
    </div>
  </div>
</body>
</html>
