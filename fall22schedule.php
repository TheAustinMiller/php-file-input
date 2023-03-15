<?php
// Create the page header
createPageHeader();

// Display the title
echo "<h3>Schedule of Classes</h3>";

// Open the text file and read the list of movies
$filename = "fall22schedule.txt";
$fp = openFile($filename, "r");

// If the value of $fp is false, then display an error message and exit
if (!$fp) {
    echo "Could not open the {$filename} file.";
    exit();
}

// Define the default movie type
$param = "all";

// Read movie selection, if there is a request for a particular type.
if (isset($_GET["param"])) {
    $param = trim($_GET["param"]);
}

if ($param === "all") {
    // Fetch a list of all the movies
    $schedule = getAllClasses($fp);
} else {
    // Fetch a list of selected movies
    $schedule = getSelectedClass($fp, $param);
}


// Define labels for columns
$columnLabels = ["Course", "Section", "Instructor", "Time", "Location"]; 

// Create table header
createTableHeader($columnLabels);

// Display links
displaySubjectLinks();
displayLocationLinks();

// Display a list of movies
displayMovieList($schedule);
    
// Close the table structure
createTableFooter();

// Close the page content
echo "</body></html>";

// Close the text file
fclose($fp);
// End main section

// Define functions
function createPageHeader() {
    // include the necessary HTML tags to create the page and add style rules or links to style files
?>
<!-- Use HTML tags to structure the content. -->
<!doctype html>
<html>
<head>
<style type="text/css">
    
    table { 
        border: 1px solid black; 
        border-collapse: collapse; 
        background: #fff; 
    }
    
    th, td { 
        border: 1px solid black; 
        padding: .2em .7em;   
        color: #000;
        font-size: 16px; 
        font-weight: 400; 
    } 
    
    thead th { 
        background-color: #1A466A; 
        color: #fff; 
        font-weight: bold;  
    }

    .link {
            padding: 10px 20px;
    }

</style>
</head>
<body>
<?php
} // end function

function openFile($filename, $mode) {
    /* This functions opens the specified file. Either it returns the file pointer or the boolean value false. */
    // Open the text file for reading
    $fp = fopen($filename, $mode);

    if (!$fp) {
        return false;
    }
    return $fp;
            
} // End function
function getAllClasses($fp) {

    // Define a variable (empty array) to store movies
    $list = [];
    
    /* Each line contains information about a movie.
        Format: id, title, year, genre
        As long as a line can be read from the text file, do the following:
            1. read each line into an array using the fgetcsv( ) method. Use ',' as the field separator.
            2. Each array contains movie data. Add each array  to the $list
    */
    while ($class = fgetcsv($fp, 255, ',')) {
        $list[] = $class;
    }
        
    return $list;
} // end function

function createTableHeader($columnLabels) {
?>
    <table>
    <thead>
        <tr>
        <?php
            // Display column label
            foreach($columnLabels as $label) {
                echo "<th>{$label}</th>";
            }
        ?>
        <tr>
    </thead>
    <tbody>
<?php
} // end function

function displayMovieList($list) {

    foreach($list as $class) {
        echo "<tr>";
        echo "<td>$class[1] $class[2]</td>";
        echo "<td>{$class[3]}</td>";
        echo "<td>{$class[4]}</td>";
        echo "<td>{$class[5]}</td>";
        echo "<td>{$class[6]}</td>";
        echo "</tr>";
    }
} // end function

function createTableFooter() {
    echo "</tbody></table>";
} // end function

function displaySubjectLinks() {
    ?>
        <p>Subjects: </p>
        <p>
            <span class="link"><a href="fall22schedule.php?param=all">All subjects</a></span>
            <span class="link"><a href="fall22schedule.php?param=COMPSCI">Computer Science</a></span>
            <span class="link"><a href="fall22schedule.php?param=MATH">Mathematics</a></span>
        </p>
    <?php
    }

    function displayLocationLinks() {
        ?>
            <p>Locations: </p>
            <p>
                <span class="link"><a href="fall22schedule.php?param=MG0115">MG0115</a></span>
                <span class="link"><a href="fall22schedule.php?param=MG0125">MG0125</a></span>
                <span class="link"><a href="fall22schedule.php?param=HY0210">HY0210</a></span>
            </p>
        <?php
        }

    function getSelectedClass($fp, $param) {
        // Define a variable (empty array) to store classes
        $list = [];
        
        while ($class = fgetcsv($fp, 255, ',')) {
            if (trim($class[1]) == $param) {
                $list[] = $class;
            }
            if (trim($class[6]) == $param) {
                $list[] = $class;
            }
        }
        
        return $list;
    }
 
