<?php require_once '../config/connection.php' ?>

<?php
///// check for API security
if ($apiKey!=$expectedApiKey){
	$response = [
        'response' => 98,
        'success'=> false,
        'message'=> 'SECURITY ACCESS DENIED! You are not allowed to execute this command due to a security breach.'
    ]; 
	goto end;
}

    $loanId = ($_GET['loanId']);
    $searchKeywords = ($_GET['searchKeywords']);

    $select=
        "SELECT * FROM loan_request_tab
        WHERE loanId LIKE '%$loanId%'
        AND (fullName LIKE '%$searchKeywords%') 
        ORDER BY fullName ASC";
        
        $query=mysqli_query($conn,$select)or die (mysqli_error($conn));
        $allRecordCount=mysqli_num_rows($query);

        if($allRecordCount==0){
            $response = [
                'response'=> 200,
                'success'=> false,
                'message'=> 'No Record found!!!'
            ];  
            goto end;
        }

            $response = [
                'response'=> 200,
                'success'=> true,
                'allRecordCount'=> $allRecordCount,
                'data'=>  array()
            ];  

            while ($fetchQuery = mysqli_fetch_assoc($query)) {
                $response['data'][] = $fetchQuery;
            }

end:
echo json_encode($response);
?>