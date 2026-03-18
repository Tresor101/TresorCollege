<?php
require_once 'dbc.php';
include 'navbar.php';

// Teacher ID (should be from session or login, here for demo)
$teacher_id = $_GET['teacher_id'] ?? 1;

// Get teacher's class
$class = null;
$class_id = null;
$class_sql = "SELECT c.id, c.class_grade, c.academic_year FROM classes c
    JOIN teacher_class_subjects tcs ON tcs.class_id = c.id
    WHERE tcs.teacher_id = ? LIMIT 1";
$stmt = $conn->prepare($class_sql);
$stmt->bind_param('i', $teacher_id);
$stmt->execute();
$class_result = $stmt->get_result();
if ($class_result && $row = $class_result->fetch_assoc()) {
    $class = $row;
    $class_id = $row['id'];
}
$stmt->close();

// Get subjects for the class
$subjects = [];
if ($class_id) {
    $sql = "SELECT s.id, s.name FROM subjects s
        JOIN teacher_class_subjects tcs ON tcs.subject_id = s.id
        WHERE tcs.class_id = ? AND tcs.teacher_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $class_id, $teacher_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $subjects[] = $row;
    }
    $stmt->close();
}

// Get students in the class
$students = [];
if ($class_id) {
    $sql = "SELECT s.id, s.first_name, s.last_name FROM students s
        JOIN class_student_enrollments cse ON cse.student_id = s.id
        WHERE cse.class_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $class_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
    $stmt->close();
}

// Handle mark submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subject_id'], $_POST['trimester'])) {
    $subject_id = intval($_POST['subject_id']);
    $trimester = $_POST['trimester'];
    $academic_year = $class['academic_year'];
    foreach ($students as $student) {
        $mark = isset($_POST['mark_' . $student['id']]) ? floatval($_POST['mark_' . $student['id']]) : null;
        $remark = isset($_POST['remark_' . $student['id']]) ? $_POST['remark_' . $student['id']] : '';
        if ($mark !== null) {
            // Insert or update mark
            $sql = "INSERT INTO student_marks (student_id, class_id, subject_id, academic_year, trimester, mark, remark)
                VALUES (?, ?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE mark = VALUES(mark), remark = VALUES(remark), updated_at = CURRENT_TIMESTAMP";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('iiissds', $student['id'], $class_id, $subject_id, $academic_year, $trimester, $mark, $remark);
            $stmt->execute();
            $stmt->close();
        }
    }
    $success = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Marks Entry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <h1 class="mb-4">Enter Marks for <?= htmlspecialchars($class['class_grade'] ?? 'Class') ?> (<?= htmlspecialchars($class['academic_year'] ?? '') ?>)</h1>
    <?php if (!empty($success)): ?>
        <div class="alert alert-success">Marks saved successfully!</div>
    <?php endif; ?>
    <form method="post">
        <div class="mb-3">
            <label for="subject_id" class="form-label">Subject</label>
            <select name="subject_id" id="subject_id" class="form-select" required>
                <option value="">Select subject</option>
                <?php foreach ($subjects as $subject): ?>
                    <option value="<?= $subject['id'] ?>"><?= htmlspecialchars($subject['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="trimester" class="form-label">Trimester</label>
            <select name="trimester" id="trimester" class="form-select" required>
                <option value="1st">1st Trimester</option>
                <option value="2nd">2nd Trimester</option>
                <option value="3rd">3rd Trimester</option>
            </select>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Mark</th>
                    <th>Remark</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?></td>
                        <td><input type="number" name="mark_<?= $student['id'] ?>" min="0" max="100" step="0.01" class="form-control" required></td>
                        <td><input type="text" name="remark_<?= $student['id'] ?>" class="form-control"></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Save Marks</button>
    </form>
</div>
</body>
</html>
