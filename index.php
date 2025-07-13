<?php include 'config/config.php'; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <?php include "meta.php";?>
    <title><?php echo $appName ?></title>
</head>

<body>
    <section class="body-div">
        <?php include 'alert.php' ?>
    
        <div class="input-div">
            <header>
                <nav>
                    
                    <div class="logo-div">
                        <a href="<?php echo $websiteUrl?>/index">
                            <img src="all-images/images/logo.png" alt="Afootech" title="Afootech logo">
                        </a>
                    </div>

                    <ul>
                        <a href="<?php echo $websiteUrl?>/index"><li title="Request For Loan">Request For Loan</li></a>
                        <a href="<?php echo $websiteUrl?>/view-loan"><li title="View Loan Request" onclick="_fetchRecord();">View Loan Request</li></a>
                    </ul>
                </nav>
            </header>

            <div class="input-content-div">
                <div class="content-inner inner-inner">
                    <h1>Request For Loan</h1>
                   
                    <div class="form-input-div">
                        <div class="text_field_container" id="fullName_container" title="Field for Fullname">
                            <script>
                                textField({
                                    id: 'fullName',
                                    title: 'Enter Full Name Here'
                                });
                            </script> 
                        </div>

                        <div class="text_field_container" id="loanAmount_container" title="Field for Loan Amount">
                            <script>
                                textField({
                                    id: 'loanAmount',
                                    title: 'Enter Loan Amount Here'
                                });
                            </script> 
                        </div>

                        <div class="text_field_container" id="loanInterest_container" title="Field for Loan Interest">
                            <script>
                                textField({
                                    id: 'loanInterest',
                                    title: 'Enter Loan Interest Here'
                                });
                            </script> 
                        </div>

                       

                        <div class="text_field_container" id="loanDuration_container" title="Select Loan Duration">
                            <script>
                                selectField({
                                    id: 'loanDuration',
                                    title: 'Select Duration'
                                });
                                _getSelectloanDuration('loanDuration');
                            </script>
                        </div>
                    </div>
                    <div class="ourButton">
                        <button class="btn" title="Request For Loan" onclick="_loanRequest();">Request For Loan <i class="bi-check"></i></button>
                        <button class="btn clear" title="Clear" onclick="_clearFunction()">Clear</button>
                    </div>

                </div>
            </div>
        </div>


        <div class="image-div"></div>



        <!-- <div class="overlay" id='modal'>
            <div class="loanBreakDownDiv">
                <div class="title-div">
                    <h1>Loan Request Breakdown</h1>
                    <button class="close-btn" onclick="_actionModal('close')">X</button>
                </div>

                <div class="profileTableDiv">
                    <div class="profileInner">
                        <div class="profileDiv" >
                            <div class="profile-content">
                                <span>Loan Id:</span>
                                <span class="blue">LOAN102938484747476</span>
                            </div>

                            <div class="profile-content">
                                <span>Fullname:</span>
                                <span class="blue">Samuel Semako</span>
                            </div>

                            <div class="profile-content">
                                <span>Amount:</span>
                                <span class="blue">₦600,000.00</span>
                            </div>

                            <div class="profile-content">
                                <span>Total Repayment:</span>
                                <span class="blue">₦613,000.00</span>
                            </div>

                            <div class="profile-content">
                                <span>Duration:</span>
                                <span class="blue">6 months</span>
                            </div>

                            <div class="profile-content">
                                <span>Date:</span>
                                <span class="blue">2025-05-20 12:42:15</span>
                            </div>
                        </div>

                        <div class="tableContentDiv">
                            <table id="loanBreakdown">
                                <tr>
                                    <th>S/N</th>
                                    <th>MONTH(S)</th>
                                    <th>LOAN BALANCE</th>
                                    <th>SUB PAYMENT</th>
                                    <th>INTEREST</th>
                                    <th>TOTAL REPAYMENT</th>
                                </tr>

                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </section>
    
</body>

</html>