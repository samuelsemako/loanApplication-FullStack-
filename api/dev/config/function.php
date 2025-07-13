<?php
class allClass
{
    function _getSequenceCount($conn, $counterId){
        $count=mysqli_fetch_array(mysqli_query($conn,"SELECT counterValue FROM counter_tab WHERE counterId = '$counterId' FOR UPDATE"));
        $num=$count[0]+1;
        mysqli_query($conn,"UPDATE counter_tab SET counterValue = '$num' WHERE counterId = '$counterId'")or die (mysqli_error($conn));
        if ($num<10){$no='00'.$num;}elseif($num>=10 && $num<100){$no='0'.$num;}else{$no=$num;}
        return '[{"no":"'.$no.'"}]';
    }

    function _getLoanRequestDetails($conn, $loanId){
        $query=mysqli_query($conn,"SELECT * FROM loan_request_tab WHERE loanId='$loanId'")or die (mysqli_error($conn));
        $fetchQuery=mysqli_fetch_array($query);
            $response = [
                "loanId" => $fetchQuery['loanId'],
                "fullName" => $fetchQuery['fullName'],
                "loanAmount" => $fetchQuery['loanAmount'],
                "loanDuration" => $fetchQuery['loanDuration'],
                "date" => $fetchQuery['createdTime'],
            ];
		return json_encode([$response]);
    }

    function _getTotalLoanRepayment($conn, $loanId){
        $query=mysqli_query($conn,"SELECT SUM(totalMonthlyRepayment) AS totalrepayment FROM loan_repayment_tab WHERE loanId='$loanId'")or die (mysqli_error($conn));
        $fetchQuery=mysqli_fetch_array($query);
            $response = [
                "totalrepayment" => $fetchQuery['totalrepayment'],
            ];
		return json_encode([$response]);
    }


} //end of class
$callclass = new allClass();
?>
