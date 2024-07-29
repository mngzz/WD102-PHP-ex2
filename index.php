<?php 

session_start();

if (!isset($_SESSION['students'])) {
    $_SESSION['students'] = [
        "Super"       => [81, 95, 89],
        "Cali"        => [91, 85, 90],
        "Fragilistic" => [97, 90, 92],
    ];
}

function addStudent(&$students, $name, $grades) {
    if (!isset($students[$name])) {
        $students[$name] = $grades;
    } else {
        echo "Student $name already exists.<br>";
    }
}

function updateStudentGrades(&$students, $name, $newGrades) {
    if (isset($students[$name])) {
        $students[$name] = $newGrades;
    } else {
        echo "Student $name does not exist.<br>";
    }
}

function removeStudent(&$students, $name) {
    if (isset($students[$name])) {
        unset($students[$name]);
    } else {
        echo "Student $name does not exist.<br>";
    }
}

function displayStudents($students) {
    foreach ($students as $name => $grades) {
        $gradeList = implode(", ", $grades);
        echo "<tr>
                <td>" . ($name) . "</td>
                <td>" . ($gradeList) . "</td>
                <td>
                    <form method='get' style='display:inline;'>
                        <input type='hidden' name='action' value='remove'>
                        <input type='hidden' name='name' value='" . ($name) . "'>
                        <button type='submit'>Remove</button>
                    </form>
                </td>
              </tr>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['action'])) {
        $action = (trim($_GET['action']));
        $name = isset($_GET['name']) ? (trim($_GET['name'])) : '';
        $gradesString = isset($_GET['grades']) ? (trim($_GET['grades'])) : '';

        switch ($action) {
            case 'add':
                if ($name && $gradesString) {
                    $gradesArray = array_map('intval', explode(',', $gradesString));
                    addStudent($_SESSION['students'], $name, $gradesArray);
                }
                break;

            case 'remove':
                if ($name) {
                    removeStudent($_SESSION['students'], $name);
                }
                break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
</head>
<body>

    <style>
        .container{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
    </style>
    
    <div class="container">
        <h1>Student Management System</h1>

        <form method="get">
            <input type="hidden" name="action" value="add">
            
            <label for="name">Name:</label>
            <input type="text" name="name" placeholder="Name" required>
            
            <label for="grades">Grades:</label>
            <input type="text" name="grades" placeholder="Grades" required>
            
            <button type="submit">Add</button>
        </form>

        <h2>Students List</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Grades</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php displayStudents($_SESSION['students']); ?>
            </tbody>
        </table>
    </div>

</body>
</html>
