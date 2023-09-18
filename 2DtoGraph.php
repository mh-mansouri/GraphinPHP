<?php 
	//The code is developed to show how display 2D array with Graph. 
	
    // Code to handle the "token" parameter being present in the URL     
	$table_name = "Table";
    $today = date("Y/m/d");

    // Establish a database connection
    $conn = mysqli_connect('localhost', 'username', 'password', 'database');
            
    // Check the connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
            
    // Prepare the SQL query
    $sql = "SELECT Time, Weight FROM $table_name WHERE Date = '$today'";
                
    // Execute the query
    $result = mysqli_query($conn, $sql);
            
    // Check if the query was successful
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }
                
    // Initialize an empty array to store the results
    $dataArray = array();
            
    // Fetch and store the results in the array
    while ($row = mysqli_fetch_assoc($result)) {
        $dataArray[] = $row;
    }
    // Close the database connection
    mysqli_close($conn);               
?>
<html >
 <head>
    <title>2D to Graph</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>  
<body> 
    <center>
    <canvas id="myChart" width="600" height="400"></canvas>
    <script>
        // Extract Time and WeightD from the PHP array
        var labels = <?php echo json_encode(array_column($dataArray, 'Time')); ?>;
        var data = <?php echo json_encode(array_column($dataArray, 'Weight')); ?>;

        // Create a reference to the canvas element
        var ctx = document.getElementById('myChart').getContext('2d');

        // Create the chart
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Daily weight',
                    data: data,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: false
                }]
            },
            options: {
            responsive: false, // Make the chart responsive
            maintainAspectRatio: true, // Allow aspect ratio to change
            scales: {
                    x: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Time'
                        }
                    }],
                    y: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Weight (gr)'
                        }
                    }]
                }
            }
        });
    </script>
    </center>
</body>
</html>