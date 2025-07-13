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

    //////////declare my variables
    $fullName = ($_POST['fullName']);
    $loanAmount = ($_POST['loanAmount']);
    $loanInterest = ($_POST['loanInterest']);
    $loanDuration = ($_POST['loanDuration']);

    if (empty($fullName)) {
        $response = [
            'response' => 101,
            'success' => false,
            'message' => "FULL NAME MUST NOT BE EMPTY",
        ];
        goto end;
    }

    if (!preg_match("/^[a-zA-Z ]+$/", $fullName)) {
        $response = [
            'response' => 102,
            'success' => false,
            'message' => "FULL NAME MUST CONTAIN ONLY ALPHABET. INPUT A VALID VALUE TO CONTINUE",
        ];
        goto end;
    }

    if (empty($loanAmount)) { 
        $response = [
            'response' => 103,
            'success' => false,
            'message' => "LOAN AMOUNT REQUIRED! Provide LOAN AMOUNT and try again.",
        ];
        goto end;
    }

    if (!is_numeric($loanAmount) ) {
        $response = [
            'response' => 103,
            'success' => false,
            'message' => "INVALID LOAN AMOUNT! ENTER ONLY DIGITS."
        ];
        goto end;
    } 
    if ($loanAmount < 1000 || $loanAmount > 10000000) {
        $response = [
            'response' => 104,
            'success' => false,
            'message' => "INVALID LOAN AMOUNT! YOU CAN ONLY BORROW MONEY FROM 1000 TO 10000000."
        ];
        goto end;
    }

    if (empty($loanInterest)) { 
        $response = [
            'response' => 105,
            'success' => false,
            'message' => "LOAN INTEREST REQUIRED! Provide LOAN INTEREST and try again.",
        ];
        goto end;
    }

    if (!is_numeric($loanInterest)) {
        $response = [
            'response' => 106,
            'success' => false,
            'message' => "INVALID LOAN INTEREST! ENTER ONLY DIGITS."
        ];
        goto end;
    }

    if (empty($loanDuration)) { 
        $response = [
            'response' => 107,
            'success' => false,
            'message' => "LOAN DURATION REQUIRED! Provide LOAN DURATION and try again.",
        ];
        goto end;
    }

    if (!is_numeric($loanDuration)) {
        $response = [
            'response' => 108,
            'success' => false,
            'message' => "INVALID LOAN DURATION! ENTER ONLY DIGITS."
        ];
        goto end;
    }

    $loanDurationArray =['6', '12', '24'];
    if (!in_array($loanDuration, $loanDurationArray)) {
        $response = [
            'response' => 109,
            'success' => false,
            'message' => "INVALID LOAN DURATION! DURATION SHOULD BE EITHER 6, 12 OR 24 MONTHS "
        ];
        goto end;
    }

        //////////////geting sequence//////////////////////////
        $sequence=$callclass->_getSequenceCount($conn, 'LOAN');
        $array = json_decode($sequence, true);
        $no= $array[0]['no'];

        /// generate loanId //////
        $loanId='LOAN'.$no.date("Ymdhis");

        ///insert into loan request tab///  
        mysqli_query($conn,"INSERT INTO loan_request_tab
        (loanId, fullName, loanAmount, loanDuration, loanInterest, createdTime, updatedTime) VALUES
        ('$loanId', '$fullName', '$loanAmount', '$loanDuration', '$loanInterest', NOW(), NOW())")or die (mysqli_error($conn));

        $totalInterest = 0;
        $totalMonthlyRepayment = 0;
        $principal=$loanAmount;
        $repayment = $loanAmount / $loanDuration;

        // Perform loan calculations ///
        for ($month = 1; $month <= $loanDuration; $month++) {
            $interestOnLoan = ($loanInterest / 100) * $loanAmount;
            $monthlyRepayment = $repayment + $interestOnLoan;
            $loanAmount -= $repayment; 

            $monthlySchedule[] = [
                'month' => $month,
                'repayment' => (number_format($repayment, 2)),
                'interest' => (number_format($interestOnLoan, 2)),
                'monthlyRepayment' => (number_format($monthlyRepayment, 2)),
                'loanBalance' => (number_format($loanAmount, 2))
            ];
           
            $totalInterest += $interestOnLoan;
            $totalMonthlyRepayment += $monthlyRepayment;

            ///insert into loan repayment tab///  
            mysqli_query($conn,"INSERT INTO loan_repayment_tab
            (loanId, month, subPayment, interestAmount, totalMonthlyRepayment, loanBalance, createdTime, updatedTime) VALUES 
            ('$loanId', '$month', '$repayment', '$interestOnLoan', '$monthlyRepayment', '$loanAmount', NOW(), NOW())")or die (mysqli_error($conn));

        }

        // Actual result success response
        $response = [
            'response' => 200,
            'success' => true,
            'message' => 'Loan Request Successfully Processed',
            'loan Details' => [
                'fullName' => $fullName,
                'loan Interest' => "$loanInterest%",
                'loan Amount' => (number_format($principal, 2)),
                'loan Duration' => $loanDuration,
                'total Interest' => (number_format($totalInterest, 2)), 
                'total MonthlyRepayment' => (number_format($totalMonthlyRepayment, 2)), 
            ],
            'monthlySchedule' => $monthlySchedule
        ];


end:
echo json_encode($response);
?>