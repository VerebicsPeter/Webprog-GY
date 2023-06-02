<?php

require_once "classes/project.php";

$proj_repository = new ProjectRepository();

$names = $proj_repository->names();

$projects = [];
if (count($_POST) > 0) {
    if (isset($_POST['employee_name'])) {
        if (isset($_POST['project_name']) && strlen(trim($_POST['project_name'])) > 0 
         && isset($_POST['project_hours']))
        {
            if ($proj_repository->is_available_project_name($_POST['project_name']))
                $proj_repository->add(new Project($_POST['project_name'], $_POST['project_hours'], $_POST['employee_name']));
            else
                $proj_repository->update_project($_POST['project_name'],$_POST['project_hours']);
        }
        $projects = $proj_repository->get_projects_by_name($_POST['employee_name']);}
}
?>


<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Projektórák</title>
</head>
<body>
    <h1>Projektórák</h1>
    <form action="index.php" method="post">
        <label for="employee_name">Munkavállaló:</label>
        <select name="employee_name">
            <!-- alkalmazottak neve egyszer -->
            <option value=""> -- válassz ki egy dolgozót -- </option>
            <?php foreach ($names as $name): ?>
                <option value="<?=$name?>" name="employee_name"><?=$name?></option>
            <?php endforeach; ?>
        </select><br>
        <label for="project_name">Projekt neve:</label><input type="text" name="project_name"> <br>
        <label for="project_hours">Munkaórák:</label><input type="number" name="project_hours" value="0" step="1"> <br>
        <button type="submit">Hozzáad és mutat</button>

        <?php if (count($projects) > 0): ?>
            <ul>
            <h2><?=$_POST['employee_name'];?></h2>
            <?php foreach ($projects as $project): ?>
                <li><?php echo $project->project_name.' - '.$project->project_hours.' óra'; ?></li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </form>
</body>
</html>
