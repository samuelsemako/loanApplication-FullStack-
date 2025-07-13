<?php require_once '../config/connection.php' ?>

<?php
///// check for API security
if ($apiKey != $expectedApiKey) {
    $response = [
        'response' => 98,
        'success' => false,
        'message' => 'SECURITY ACCESS DENIED! You are not allowed to execute this command due to a security breach.'
    ];
    goto end;
}
    $loanId = ($_GET['loanId']);

    if (empty($loanId)){
        $response = [
            'response' => 210,
            'success' => false,
            'message' => 'Loan ID Required!!!'
        ];
        goto end;
    }

    $loanArray = $callclass->_getLoanRequestDetails($conn, $loanId);
    $fetchLoan = json_decode($loanArray, true);
    $loanId = $fetchLoan[0]['loanId'];
    $fullName = $fetchLoan[0]['fullName'];
    $loanAmount = $fetchLoan[0]['loanAmount'];
    $loanDuration = $fetchLoan[0]['loanDuration'];
    $date = $fetchLoan[0]['date'];

    $loanSumArray = $callclass->_getTotalLoanRepayment($conn, $loanId);
    $fetchLoanSum = json_decode($loanSumArray, true);
    $totalrepayment = $fetchLoanSum[0]['totalrepayment'];

    $select =
        "SELECT * FROM loan_repayment_tab
        WHERE loanId LIKE '%$loanId%'
        ORDER BY createdTime ASC";

    $query = mysqli_query($conn, $select) or die(mysqli_error($conn));
    $allRecordCount = mysqli_num_rows($query);

    if ($allRecordCount == 0) {
        $response = [
            'response' => 200,
            'success' => false,
            'message' => 'No Record found!!!'
        ];
        goto end;
    }

    $response = [
        'response' => 200,
        'success' => true,
        'loanId' => $loanId,
        'fullName' => $fullName,
        'loanAmount' => $loanAmount,
        'loanDuration' => $loanDuration,
        'totalrepayment' => $totalrepayment,
        'date' => $date,
        'data' =>  array()
    ];

    while ($fetchQuery = mysqli_fetch_assoc($query)) {
        $response['data'][] = $fetchQuery;
    }


end:
echo json_encode($response);
?>