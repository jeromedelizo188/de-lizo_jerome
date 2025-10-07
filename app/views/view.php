<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Records</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
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
            color: #616161;
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
        body::after {
            content: '';
            position: absolute;
            top: 15%; right: 15%;
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(255,255,255,0.5), transparent);
            filter: blur(80px); opacity: 0.8; z-index: 0;
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
        .soft-ui-inset {
            box-shadow: inset 5px 5px 10px #c9c9c9,
                        inset -5px -5px 10px #ffffff;
        }
        .soft-ui-hover:hover {
            box-shadow: 4px 4px 8px #c9c9c9,
                        -4px -4px 8px #ffffff;
            transform: translateY(-2px);
        }
        .soft-ui-active:active {
            box-shadow: inset 5px 5px 10px #c9c9c9,
                        inset -5px -5px 10px #ffffff;
        }
        .table-header { background-color: #e6e6e6; }
        .table-cell { border-bottom: 1px solid #d1d1d1; }
        .soft-ui-red {
            background-color: #ff6a6a;
            color: white;
            box-shadow: 6px 6px 12px #d65959,
                        -6px -6px 12px #ff7b7b;
        }
        .text-shadow { text-shadow: 1px 1px 2px rgba(0,0,0,0.1); }
        .soft-ui-link:hover {
            color: #4a4a4a;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container mx-auto max-w-6xl">
       <div class="flex flex-col sm:flex-row justify-between items-center mb-10 gap-4">
            <h1 class="text-4xl font-semibold tracking-wider px-6 py-3 rounded-2xl soft-ui text-gray-700 text-shadow">
                User Records
            </h1>
            <div class="flex gap-4">
                <a href="<?=site_url('/create');?>"
                class="font-semibold text-lg px-8 py-4 rounded-xl soft-ui soft-ui-red soft-ui-hover soft-ui-active">
                    Add New Record
                </a>
                <a href="<?=site_url('logout');?>"
                class="font-semibold text-lg px-8 py-4 rounded-xl soft-ui soft-ui-hover soft-ui-active text-gray-700">
                    Logout
                </a>
            </div>
        </div>

        <form method="get" action="<?=site_url('/view');?>" class="mb-6">
            <div class="flex items-center gap-3 soft-ui px-4 py-3 rounded-xl">
                <input 
                    type="text" 
                    name="search" 
                    value="<?=htmlspecialchars($search_term ?? '');?>"
                    placeholder="Search by name or email..."
                    class="flex-grow bg-transparent outline-none text-gray-600 placeholder-gray-400"
                >
                <button type="submit" class="px-6 py-2 rounded-lg soft-ui soft-ui-hover soft-ui-active text-gray-700 font-semibold">
                    Search
                </button>
            </div>
        </form>
        
        <div class="soft-ui p-6">
            <div class="overflow-x-auto">
                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="soft-ui-inset rounded-xl">
                            <th class="table-header px-4 sm:px-6 py-4 text-left text-sm sm:text-base font-semibold text-gray-700 uppercase tracking-wider rounded-tl-xl">ID</th>
                            <th class="table-header px-4 sm:px-6 py-4 text-left text-sm sm:text-base font-semibold text-gray-700 uppercase tracking-wider">Last Name</th>
                            <th class="table-header px-4 sm:px-6 py-4 text-left text-sm sm:text-base font-semibold text-gray-700 uppercase tracking-wider">First Name</th>
                            <th class="table-header px-4 sm:px-6 py-4 text-left text-sm sm:text-base font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                            <th class="table-header px-4 sm:px-6 py-4 text-left text-sm sm:text-base font-semibold text-gray-700 uppercase tracking-wider rounded-tr-xl">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="5" class="py-10 text-center text-gray-400 font-medium soft-ui rounded-b-xl">
                                    No records found.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($users as $user): ?>
                                <tr class="soft-ui-hover">
                                    <td class="table-cell px-4 sm:px-6 py-4 text-sm font-medium text-gray-600"><?=$user['student_id'];?></td>
                                    <td class="table-cell px-4 sm:px-6 py-4 text-sm font-medium text-gray-600"><?=$user['last_name'];?></td>
                                    <td class="table-cell px-4 sm:px-6 py-4 text-sm font-medium text-gray-600"><?=$user['first_name'];?></td>
                                    <td class="table-cell px-4 sm:px-6 py-4 text-sm font-medium text-gray-600"><?=$user['email'];?></td>
                                    <td class="table-cell px-4 sm:px-6 py-4 text-sm font-medium flex items-center space-x-2">
                                        <a class="px-4 py-2 rounded-lg soft-ui soft-ui-active soft-ui-hover text-gray-500 soft-ui-link" href="<?=site_url('/update/'.$user['student_id']);?>">Edit</a>
                                        <button class="px-4 py-2 rounded-lg text-red-500 soft-ui soft-ui-active soft-ui-hover soft-ui-link" onclick="showDeleteModal('<?=site_url('/delete/'.$user['student_id']);?>')">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if (!empty($users) && $total_pages > 1): ?>
            <div class="mt-8 flex justify-center">
                <ul class="flex items-center gap-3">
                    <?php if ($page > 1): ?>
                        <li>
                            <a href="<?=site_url('/view?search='.urlencode($search_term).'&page=1');?>"
                            class="px-4 py-2 rounded-xl soft-ui soft-ui-hover soft-ui-active text-gray-700 font-semibold">
                                ⏮ First
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($page > 1): ?>
                        <li>
                            <a href="<?=site_url('/view?search='.urlencode($search_term).'&page='.($page-1));?>"
                            class="px-4 py-2 rounded-xl soft-ui soft-ui-hover soft-ui-active text-gray-700 font-semibold">
                                ← Prev
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li>
                            <a href="<?=site_url('/view?search='.urlencode($search_term).'&page='.$i);?>"
                            class="px-4 py-2 rounded-xl font-semibold 
                                    <?= $i == $page 
                                        ? 'soft-ui-inset text-gray-600' 
                                        : 'soft-ui soft-ui-hover soft-ui-active text-gray-700'; ?>">
                                <?=$i;?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <li>
                            <a href="<?=site_url('/view?search='.urlencode($search_term).'&page='.($page+1));?>"
                            class="px-4 py-2 rounded-xl soft-ui soft-ui-hover soft-ui-active text-gray-700 font-semibold">
                                Next →
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($page < $total_pages): ?>
                        <li>
                            <a href="<?=site_url('/view?search='.urlencode($search_term).'&page='.$total_pages);?>"
                            class="px-4 py-2 rounded-xl soft-ui soft-ui-hover soft-ui-active text-gray-700 font-semibold">
                                Last ⏭
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>

    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="soft-ui rounded-xl p-8 max-w-sm mx-auto">
            <h3 class="text-xl font-semibold mb-4 text-gray-700">Confirm Deletion</h3>
            <p class="text-gray-600 mb-6">Are you sure you want to delete this record?</p>
            <div class="flex justify-end space-x-4">
                <a id="deleteConfirmBtn" class="soft-ui-red soft-ui-hover soft-ui-active text-white font-semibold px-6 py-2 rounded-lg">Yes</a>
                <button class="bg-gray-300 text-gray-700 font-semibold px-6 py-2 rounded-lg soft-ui-hover soft-ui-active" onclick="hideDeleteModal()">No</button>
            </div>
        </div>
    </div>

    <script>
        function showDeleteModal(deleteUrl) {
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteConfirmBtn').href = deleteUrl;
        }
        function hideDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>
</body>
</html>
