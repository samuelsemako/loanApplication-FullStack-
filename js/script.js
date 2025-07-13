function _actionModal(action) {
  if (action === "open") {
    $("#modal").css("display", "flex");
  } else if (action === "close") {
    $("#modal").css("display", "none").fadeOut(200);
  }
}

function _loanRequest() {
  const fullName = $("#fullName").val().trim();
  const loanAmount = $("#loanAmount").val();
  const loanInterest = $("#loanInterest").val();
  const loanDuration = $("#loanDuration").val();

  $("#fullName, #emailAddress, #phoneNumber, #passport").removeClass("issue");

  // === VALIDATIONS ===
  if (!fullName) {
    $("#fullName").addClass("issue");
    _actionAlert("USER ERROR! Kindly provide fullname to continue", false);
    return;
  }

  if (!fullName) {
    $("#fullName").addClass("issue");
    _actionAlert("Provide fullname to continue", false);
    return;
  }

  const nameRegex = /^[A-Za-z\s]+$/;

  if (!loanAmount) {
    $("#loanAmount").addClass("issue");
    _actionAlert("Provide loan amount to continue", false);
    return;
  }

  if (!parseInt(loanAmount)) {
    $("#loanAmount").addClass("issue");
    _actionAlert("Loan amount must be numeric", false);
    return;
  }

  if (parseFloat(loanAmount) < 1000 || parseFloat(loanAmount) > 1000000) {
    $("#loanAmount").addClass("issue");
    _actionAlert(
      "Loan amount must be a number between 1,000 and 1,000,000",
      false
    );
    return;
  }

  if (!loanInterest) {
    $("#loanInterest").addClass("issue");
    _actionAlert("Provide loan interest to continue", false);
    return;
  }

  if (!parseInt(loanInterest)) {
    $("#loanInterest").addClass("issue");
    _actionAlert("Loan interest must be numeric", false);
    return;
  }

  if (!loanDuration) {
    $("#loanDuration").addClass("issue");
    _actionAlert("You must select loan duration to continue", false);
    return;
  }

  if (loanDuration !== "6" && loanDuration !== "12" && loanDuration !== "24") {
    $("#loanDuration").addClass("issue");
    _actionAlert("You have to select right duration to continue", false);
    return;
  }

  const formData = new FormData();
  formData.append("fullName", fullName);
  formData.append("loanAmount", loanAmount);
  formData.append("loanInterest", loanInterest);
  formData.append("loanDuration", loanDuration);

  $.ajax({
    type: "POST",
    url: endPoint + "/loan/loan-request",
    data: formData,
    dataType: "json",
    contentType: false,
    cache: false,
    processData: false,
    headers: {
      apiKey: apiKey,
    },
    success: function (info) {
      const success = info.success;
      const message = info.message;

      if (success === true) _actionAlert(message, true), _clearFunction();
      else _actionAlert(message, false);
    },
    error: function () {
      _actionAlert(
        "An error occurred while processing your request! Please Try Again",
        false
      );
    },
  });
}

function _fetchRecord() {
  $.ajax({
    type: "GET",
    url: endPoint + "/loan/fetch-loan-request",
    dataType: "json",
    headers: {
      apiKey: apiKey,
    },
    success: function (response) {
      const records = response.data;
      $("#recordContainer").html(""); // Clear existing records

      records.forEach((record) => {
        let html = `
                    <div class="content-inner" onclick="_fetchBreakdown('${record.loanId}')">
                        <div class="top-container">
                            <h2 class="loanId">${record.loanId}</h2>
                            <h2 class="name">${record.fullName}</h2>
                        </div>
                        <div class="date-price">
                            <span class="loanAmount">₦${record.loanAmount}</span>
                            <span class="colored loanDuration">${record.loanDuration} Months</span>
                        </div>
                    </div>
                `;
        $("#recordContainer").append(html);
      });
    },
    error: function () {
      _actionAlert(
        "Failed to fetch loan records. Please try again later.",
        false
      );
    },
  });
}

function _fetchBreakdown(loanId) {
  $.ajax({
    type: "GET",
    url: endPoint + "/loan/fetch-loan-breakdown?loanId=" + loanId,
    dataType: "json",
    headers: {
      apiKey: apiKey,
    },
    success: function (response) {
      const records = response.data;

      $("#loanBreakdown").html(""); // Clear existing rows

      if (!response.success || records.length === 0) {
        _actionAlert("No breakdown found for this loan.", false);
        return;
      }

       

      let sn = 1;
      let text = "";
      records.forEach((record) => {
        text += `
                    <tr>
                        <td>${sn++}</td>
                        <td>${record.month}</td>
                        <td>₦${Number(record.loanBalance).toLocaleString()}</td>
                        <td>₦${Number(record.subPayment).toLocaleString()}</td>
                        <td>₦${Number(record.interestAmount).toLocaleString()}</td>
                        <td>₦${Number(record.totalMonthlyRepayment).toLocaleString()}</td>

                    </tr>`;
      });
      _actionAlert(loanId, true);
      $("#loanBreakdown").append(text);
      _actionModal("open");
    },
    error: function () {
      _actionAlert(
        "Failed to fetch loan breakdown. Please try again later.",
        false
      );
    },
  });
}

function _clearFunction() {
  $("#fullName, #loanAmount, #loanInterest, #loanDuration").val("");
}
