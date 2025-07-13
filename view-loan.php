<?php include 'config/config.php'; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <?php include "meta.php"; ?>
    <title><?php echo $appName ?></title>
</head>

<body>
    <section class="body-div">
        <?php include 'alert.php' ?>
        <script>
            _fetchRecord()
        </script>
        <div class="input-div">
            <header>
                <nav>
                    <div class="logo-div">
                        <a href="<?php echo $websiteUrl ?>/index">
                            <img src="all-images/images/logo.png" alt="Afootech" title="Afootech logo">
                        </a>
                    </div>

                    <ul>
                        <a href="<?php echo $websiteUrl ?>/index">
                            <li title="Request Loan">Request Loan</li>
                        </a>
                    </ul>
                </nav>
            </header>

            <div class="input-content-div">
                <div class="details">
                    <div class="title-div">
                        <h1>All Loan Requests</h1>
                        <div class="text_field_container" id="searchKeywords_container" title="Field for Key words">
                            <script>
                                textField({
                                    id: 'searchKeywords',
                                    title: 'Enter Loan Keywords Here'
                                });
                            </script>
                        </div>

                    </div>

                    <div class="details-content" id="recordContainer">

                    </div>
                </div>
            </div>
        </div>


        <div class="image-div"></div>

        <div class="overlay" id='modal'>

            <div class="loanBreakDownDiv">
                <div class="title-div">
                    <h1><i class=""></i> Loan Request Breakdown</h1>
                    <button class="close-btn" onclick="_actionModal('close')">X</button>
                </div>

                <div class="profileTableDiv">
                    <div class="profileInner">
                        <div class="profileDiv">
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


                                <script>
                                    _fetchBreakdown(loanId)
                                </script>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>