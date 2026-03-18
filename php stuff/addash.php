<?php
// addash.php
// Authentication removed as requested
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - iBangu College</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="min-height: 100vh;">
    <?php include 'navbar.php'; ?>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        body {
            flex: 1 0 auto;
            display: flex;
            flex-direction: column;
        }
        main, .container, .content {
            flex: 1 0 auto;
        }
        @keyframes gradientBG {
            0% {background-position: 0% 50%;}
            50% {background-position: 100% 50%;}
            100% {background-position: 0% 50%;}
        }
        .dashboard-btn {
            border: none;
            border-radius: 1.5rem;
            box-shadow: 0 4px 24px rgba(0,0,0,0.12), 0 1.5px 4px rgba(0,0,0,0.10);
            transition: transform 0.15s, box-shadow 0.15s, background 0.3s;
            font-size: 1.3rem;
            letter-spacing: 0.5px;
            background: linear-gradient(90deg, #43e97b 0%, #38f9d7 100%);
            color: #fff;
        }
        .dashboard-btn.btn-outline-success {
            background: #fff;
            color: #43e97b;
            border: 2px solid #43e97b;
        }
        .dashboard-btn.btn-primary {
            background: linear-gradient(90deg, #396afc 0%, #2948ff 100%);
            color: #fff;
        }
        .dashboard-btn.btn-warning {
            background: linear-gradient(90deg, #f7971e 0%, #ffd200 100%);
            color: #232526;
        }
        .dashboard-btn.btn-info {
            background: linear-gradient(90deg, #43cea2 0%, #185a9d 100%);
            color: #fff;
        }
        .dashboard-btn.btn-secondary {
            background: linear-gradient(90deg, #757f9a 0%, #d7dde8 100%);
            color: #232526;
        }
        .dashboard-btn.btn-danger {
            background: linear-gradient(90deg, #ff5858 0%, #f09819 100%);
            color: #fff;
        }
        .dashboard-btn:hover, .dashboard-btn:focus {
            transform: translateY(-4px) scale(1.03);
            box-shadow: 0 8px 32px rgba(0,0,0,0.18), 0 2px 8px rgba(0,0,0,0.13);
            filter: brightness(1.08);
        }
        .dashboard-btn .bi {
            font-size: 1.5rem;
            vertical-align: middle;
        }
    </style>
    <div class="container mt-5">
        <h1 class="mb-4">Student List</h1>
        <?php
        // Enable error reporting for debugging
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        require_once 'dbc.php';
        $result = $conn->query("SELECT student_id, full_name FROM students ORDER BY student_id ASC");
        if (!$result) {
            echo '<div class="no-students">Database error: ' . htmlspecialchars($conn->error) . '</div>';
        }
        ?>
        <style>
        body {
            background: linear-gradient(120deg, #ffecd2 0%, #fcb69f 100%);
            min-height: 100vh;
        }
        .search-bar-container {
            display: flex;
            justify-content: center;
            margin-top: 2.5rem;
            margin-bottom: 0.5rem;
        }
        .search-bar {
            width: 100%;
            max-width: 400px;
            padding: 0.7rem 1.2rem;
            border-radius: 2rem;
            border: none;
            font-size: 1.08rem;
            box-shadow: 0 2px 12px rgba(252,182,159,0.13);
            outline: none;
            background: #fff;
            color: #232526;
            transition: box-shadow 0.18s;
        }
        .search-bar:focus {
            box-shadow: 0 4px 18px rgba(252,182,159,0.22);
        }
        .student-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 2rem;
            margin: 2.5rem 0 2rem 0;
        }
        .student-card {
            background: linear-gradient(120deg, #232526 60%, #7f53ac 100%);
            border-radius: 1.2rem;
            box-shadow: 0 6px 32px rgba(127,83,172,0.18), 0 1.5px 8px rgba(0,0,0,0.18);
            padding: 2.2rem 1.5rem 1.5rem 1.5rem;
            color: #fff;
            position: relative;
            overflow: hidden;
            transition: transform 0.18s, box-shadow 0.18s;
        }
        .student-card:hover {
            transform: translateY(-7px) scale(1.03);
            box-shadow: 0 12px 40px rgba(127,83,172,0.28), 0 2px 12px rgba(0,0,0,0.22);
        }
        .student-id {
            font-size: 1.2rem;
            font-weight: 700;
            color: #ffb86c;
            letter-spacing: 0.5px;
        }
        .student-name {
            font-size: 1.05rem;
            font-weight: 500;
            margin-top: 0.7rem;
            color: #f8f8f2;
        }
        .no-students {
            color: #fff;
            background: rgba(127,83,172,0.18);
            border-radius: 1rem;
            padding: 2rem;
            text-align: center;
            margin: 2rem auto;
            font-size: 1.2rem;
            max-width: 400px;
        }
        </style>
        <div class="search-bar-container">
            <input type="text" id="searchBar" class="search-bar" placeholder="Search by ID or Name...">
        </div>
        <div class="student-grid" id="studentGrid">
        <?php
        $studentCards = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $studentCards[] = [
                    'id' => htmlspecialchars($row['student_id']),
                    'name' => htmlspecialchars($row['full_name'])
                ];
            }
        }
        ?>
        <?php if (count($studentCards) > 0): ?>
            <?php foreach ($studentCards as $card): ?>
                <div class="student-card" data-id="<?php echo strtolower($card['id']); ?>" data-name="<?php echo strtolower($card['name']); ?>">
                    <div class="student-id">ID: <?php echo $card['id']; ?></div>
                    <div class="student-name"><?php echo $card['name']; ?></div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-students">No students found.</div>
        <?php endif; ?>
        </div>
        <script>
        // Simple client-side search for student cards
        document.getElementById('searchBar').addEventListener('input', function() {
            const query = this.value.trim().toLowerCase();
            const cards = document.querySelectorAll('.student-card');
            let anyVisible = false;
            cards.forEach(card => {
                const id = card.getAttribute('data-id');
                const name = card.getAttribute('data-name');
                if (id.includes(query) || name.includes(query)) {
                    card.style.display = '';
                    anyVisible = true;
                } else {
                    card.style.display = 'none';
                }
            });
            // Show/hide no-students message
            const noStudents = document.querySelector('.no-students');
            if (noStudents) {
                noStudents.style.display = anyVisible ? 'none' : '';
            }
        });
        </script>
    </div>


    <?php include 'footer.php'; ?>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
