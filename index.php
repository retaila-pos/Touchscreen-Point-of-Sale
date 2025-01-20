<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

 <link rel="icon" type="image/png" href="https://pos.retailcentral.com.au/images/logo.png">
    <!-- Other head elements like stylesheets or scripts go here -->
<link id="theme-link" href="style-light-theme.css?ver=3.23" rel="stylesheet">
<link href="custom.css?ver=2.3" rel="stylesheet">
<link rel="manifest" href="manifest.json">
<!--
<script src="https://serratus.github.io/quaggaJS/examples/js/quagga.min.js"></script>
-->

<script src="https://js.stripe.com/v3/"></script>
<script src="https://js.stripe.com/terminal/v1/"></script>
<script type="text/javascript" src="terminal.js?ver=2.09"></script>
<!-- <script src="https://pos.retailcentral.com.au/include/stripe.js"></script> -->
</head>
<body>
<!-- Title Bar Config -->
<div id="titleBarContainer">
      <div id="titleBar" class=" draggable">
	  <!-- Header -->
	<div class="header container-fluid d-flex XXjustify-content-between align-items-center">
		<img src="images/logo.png" alt="Logo" style="height: 20px; width: auto;">
		<span id="memberDetail">RetailCentral | POS </span>
	</div>
</div>

<!-- Install Prompt Modal -->
<div class="modal fade" id="install" tabindex="-1" role="dialog" aria-labelledby="installPromptLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="installPromptLabel">Install App</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Would you like to install this application on your device?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Not now</button>
        <button type="button" class="btn btn-primary" id="confirmInstall">Install</button>
      </div>
    </div>
  </div>
</div>

  
  <div id="mainContent">
    <div class="container row">

<div class="col-lg-4 col-md-6 col-sm-12"> 
    <div id="saleContainer" class="sale-container">
        <!-- Sale Products list box -->
        <table id="saleTable" class="table  sale-box">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Value</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <!-- Sale items will be added here dynamically -->
            </tbody>
        </table>
    </div>
</div>

<div class="col-lg-4 col-md-6 col-sm-12">
   <div id="keypad-container">
   <div id="plu-input-container">
           <input type="text" id="display" inputmode="none" placeholder="Enter PLU or Price...">
	</div>
   <div id="keypad" class="keypad">
        <button class="key" data-key="1">1</button>
        <button class="key" data-key="2">2</button>
        <button class="key" data-key="3">3</button>
        <button class="key" data-key="4">4</button>
        <button class="key" data-key="5">5</button>
        <button class="key" data-key="6">6</button>
        <button class="key" data-key="7">7</button>
        <button class="key" data-key="8">8</button>
        <button class="key" data-key="9">9</button>
        <button class="key">.</button>
        <button class="key"data-key="0">0</button>

        <button id="enter" class="key btn-primary">ENTER</button>
        <button id="search" class="key">SEARCH</button>
		<button id="dept" class="key" style="display:none;">DEPT</button> <!--Radio Selection method -->
		<button id="deptButton" class="key">DEPT</button> <!-- display Dept choices by buttons -->
		<button id="member" class="key">MEMBER</button>
        <button id="clear" class="key btn-warning">CLEAR</button>
        <button id="cancel-sale" class="key btn-danger">CANCEL SALE</button>
		<button id="expense" class="key">Expense</button>
<!--	<button id="scan" class="key btn-primary">SCAN</button> -->
		<button id="generateReceipt" class="key btn-primary" disabled>Receipt</button>
		<!-- receiptServerBtn -->
        <button id="refund" class="key btn-danger">Refund</button>
        <button id="pay" class="key btn-success">PAY</button>
    </div>
	        <div id="subtotalContainer" class="subtotal-container">
            <div id="subtotalDisplay">
                Subtotal:
            </div>
            <div class="h1">
                $<span id="subtotal">0.00</span>
            </div>
        </div>
	</div>
</div>

      <div class="col-lg-4 col-md-6 col-sm-12">
        <!-- Product 'fast keys' -->
		<div id="fast-keys-container"></div> 
	  </div>
	  
    </div>
  </div>

  <!-- Search Modal -->
  <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="searchModalLabel">Search Products</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">Close(X)</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="text" id="productSearch" placeholder="Search for products..." class="form-control">
          <ul id="items-list" class="list-group" style="padding-top:5px; font-weight:bold;">
            <!-- Items will be added here dynamically -->
          </ul>
        </div>
      </div>
    </div>
  </div>
  
    <!-- Customer/Member Modal -->
    <div class="modal fade" id="memberModal" tabindex="-1" role="dialog" aria-labelledby="memberModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="memberModalLabel">Search Members</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" id="memberSearch" placeholder="Search for Member..." class="form-control" oninput="searchContacts(event)">
                    <ul id="members-list" class="list-group mt-2">
                        <!-- Members will be added here dynamically -->
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                    <button type="button" id="memberOK" class="btn btn-primary" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

  
  <!-- Barcode Scanner modal -->
  <div class="modal fade" id="scannerModal" tabindex="-1" role="dialog" aria-labelledby="scannerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-height: 60vh;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="scannerModalLabel">Scan Item</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="text" id="scanSearch" placeholder="Scan Item Barcode.." class="form-control" readonly>
          <ul id="scan-item-list" class="list-group">
            <!-- Items will be added here dynamically -->
			<style>
			.viewport {
			width:100%;
			height:40%;
			margin-top:30px;
			}
			
			#interactive video {
    width: 100%; /* Set this to whatever width you desire */
    height: auto; /* Maintain aspect ratio */
}

	
	    .drawingBuffer {
        display: none;
    }

			</style>
    <div id="interactive" class="viewport"></div>
	<!--
    <script>
Quagga.init({
    inputStream: {
        name: "Live",
        type: "LiveStream",
        target: document.querySelector('#interactive')
    },
    constraints: {
        width: 480,
        height: 320,
        facingMode: "environment"
    },
    area: {
        top: "0%",    // top offset
        right: "0%",  // right offset
        left: "0%",   // left offset
        bottom: "0%"  // bottom offset
    },
    singleChannel: false, // <-- Note the comma here
    decoder: {
        readers: ["ean_reader"]
    }
}, function(err) {
    if (err) {
        console.log(err);
        return;
    }
    console.log("Initialization finished. Ready to start");
    Quagga.start();
});


        Quagga.onDetected(function(result) {
            var code = result.codeResult.code;

            alert("Barcode detected and read!\n\nCode: " + code);
			document.getElementById('scanSearch').value = code;
			document.getElementById('display').value = code;
        });
    </script>
	-->
          </ul>
        </div>
     <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
        <button type="button" id="scanOK" class="btn btn-primary" data-dismiss="modal">OK</button>
      </div>
    </div> 
    </div>
    </div>
  </div>
  
  
  
 <!-- Expense Modal -->
 <!--
<div class="modal fade" id="expenseModal" tabindex="-1" aria-labelledby="expenseModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content modal-content-expense">
      <div class="modal-header">
        <h5 class="modal-title" id="expenseModalLabel">Select Expense</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
<div class="modal-body" style="display:block; padding-top:20px; padding-bottom:20px; font-size:16px;">
  <div class="form-check" style="padding:5px;">
    <input class="form-check-input" type="radio" name="expense" id="EFTPOSFEES" value="EFTPOSFEES" required>
    <label class="form-check-label" for="beer">EftPOS Fees</label>
  </div>
  <div class="form-check" style="padding:5px;">
    <input class="form-check-input" type="radio" name="expense" id="variance" value="FOOD">
    <label class="form-check-label" for="wine">Till Variance</label>
  </div>
  <div class="form-check" style="padding:5px;">
    <input class="form-check-input" type="radio" name="expense" id="entertainment" value="ENTERTAINMENT">
    <label class="form-check-label" for="golf">Entertainment</label>
  </div>
  <!--
  <div class="form-check">
    <input class="form-check-input" type="radio" name="dept" id="noalc" value="NoALC">
    <label class="form-check-label" for="noalc">NoALC</label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="radio" name="dept" id="food" value="FOOD">
    <label class="form-check-label" for="food">FOOD</label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="radio" name="dept" id="sundry" value="SUNDRY">
    <label class="form-check-label" for="sundry">SUNDRY</label>
  </div> 
  <div class="form-group mt-4">
    <label for="tradingDate">Trading Date:</label>
    <input type="date" class="form-control" id="tradingDate" name="tradingDate" required>
    <label for="sellPrice">Value:</label>
    <input type="number" class="form-control" id="sellPrice" name="sellPrice" min="0" step="0.01" required>
  </div>
</div>
     <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
        <button type="button" id="expenseOK" class="btn btn-primary">OK</button>
      </div>
    </div>
  </div>
</div>
-->
  
<!-- Department Modal  -->
<div class="modal fade" id="deptModal" tabindex="-1" aria-labelledby="deptModalLabel" aria-hidden="true" style="display:none;">
  <div class="modal-dialog">
    <div class="modal-content modal-content-dept">
      <div class="modal-header">
        <h5 class="modal-title" id="deptModalLabel">Select Department</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
      </div>
<div class="modal-body" style="display:block; padding-top:20px; padding-bottom:20px; font-size:16px;">
  <div class="form-check" style="padding:5px;">
    <input class="form-check-input" type="radio" name="dept" id="BAR" value="BAR" required>
    <label class="form-check-label" for="beer">BAR</label>
  </div>
  <div class="form-check" style="padding:5px;">
    <input class="form-check-input" type="radio" name="dept" id="FOOD" value="FOOD">
    <label class="form-check-label" for="wine">FOOD</label>
  </div>
    <div class="form-check" style="padding:5px;">
    <input class="form-check-input" type="radio" name="dept" id="GOLF" value="GOLF">
    <label class="form-check-label" for="golf">GOLF</label>
  </div>
  <div class="form-check" style="padding:5px;">
    <input class="form-check-input" type="radio" name="dept" id="RETAIL" value="RETAIL">
    <label class="form-check-label" for="rtd">RETAIL</label>
  </div>
    <div class="form-check" style="padding:5px;">
    <input class="form-check-input" type="radio" name="dept" id="MEMBERSHIP" value="MEMBERSHIP">
    <label class="form-check-label" for="rtd">MEMBERSHIP</label>
  </div>
  <div class="form-check" style="padding:5px;">
    <input class="form-check-input" type="radio" name="dept" id="RAFFLES" value="RAFFLES">
    <label class="form-check-label" for="rtd">RAFFLES</label>
  </div>
    <div class="form-check" style="padding:5px;">
    <input class="form-check-input" type="radio" name="dept" id="HONESTYBOX" value="HONESTYBOX">
    <label class="form-check-label" for="rtd">HONESTY BOX</label>
   </div>
     <div class="form-check" style="padding:5px;">
    <input class="form-check-input" type="radio" name="dept" id="SPONSORSHIP" value="SPONSORSHIP">
    <label class="form-check-label" for="rtd">SPONSORSHIP</label>
   </div>
    <div class="form-check" style="padding:5px;">
    <input class="form-check-input" type="radio" name="dept" id="PAIDOUT" value="PAIDOUT">
    <label class="form-check-label" for="rtd">PAIDOUT</label>
   </div>
  <div class="form-group mt-4">
    <label for="sellPrice">Sell Price:</label>
    <input type="number" class="form-control" id="sellPrice" name="sellPrice" min="0" step="0.01" inputmode="none" required>
  </div>
</div>

     <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
        <button type="button" id="deptOK" class="btn btn-primary" disabled>OK</button>
      </div>
    </div>
  </div>
</div>

<!-- New Department Button Modal with 3-Column Grid -->
<div class="modal fade" id="deptButtonModal" tabindex="-1" aria-labelledby="deptButtonModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content modal-content-dept">
      <div class="modal-header">
        <h5 class="modal-title" id="deptButtonModalLabel">Select Department</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">x</button>
      </div>
      <div class="modal-body" style="display:block; padding-top:20px; padding-bottom:20px; font-size:16px;">
        <div class="container">
          <div class="form-group mt-4">
            <label for="sellPriceButton">Sell Price:</label>
            <input type="number" class="form-control" id="sellPriceButton" name="sellPrice" min="0" step="0.01" inputmode="none" required>
          </div>
          <div class="row">
            <div class="col-6 col-md-4 mb-3">
              <button type="button" class="btn btn-info dept-button w-100" data-dept="BAR">BAR</button>
            </div>
            <div class="col-6 col-md-4 mb-3">
              <button type="button" class="btn btn-info dept-button w-100" data-dept="FOOD">FOOD</button>
            </div>
            <div class="col-6 col-md-4 mb-3">
              <button type="button" class="btn btn-info dept-button w-100" data-dept="GOLF">GOLF</button>
            </div>
            <div class="col-6 col-md-4 mb-3">
              <button type="button" class="btn btn-info dept-button w-100" data-dept="RETAIL">RETAIL</button>
            </div>
            <div class="col-6 col-md-4 mb-3">
              <button type="button" class="btn btn-info dept-button w-100" data-dept="MEMBERSHIP">MEMBERSHIP</button>
            </div>
            <div class="col-6 col-md-4 mb-3">
              <button type="button" class="btn btn-info dept-button w-100" data-dept="RAFFLES">RAFFLES</button>
            </div>
            <div class="col-6 col-md-4 mb-3">
              <button type="button" class="btn btn-info dept-button w-100" data-dept="HONESTYBOX">HONESTY BOX</button>
            </div>
            <div class="col-6 col-md-4 mb-3">
              <button type="button" class="btn btn-info dept-button w-100" data-dept="SPONSORSHIP">SPONSORSHIP</button>
            </div>
            <div class="col-6 col-md-4 mb-3">
              <button type="button" class="btn btn-info dept-button w-100" data-dept="PAIDOUT">PAID OUT</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
      </div>
    </div>
  </div>
</div>

    
<!-- Pay Modal -->
<div class="modal fade" id="payModal" tabindex="-1" role="dialog" aria-labelledby="payModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="payModalLabel">Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="payment-options-none"><h2>No Sale in Progress</h2></div>

        <div id="payment-options" class="payment-options">
          <div class="row">
            <div class="col-4 ">
              <button type="button" class="btn btn-lg btn-warning btn-block tender-type" id="cash5">CASH $5</button>
            </div>
            <div class="col-4 ">
              <button type="button" class="btn btn-lg btn-warning btn-block tender-type" id="cash10">CASH $10</button>
            </div>
            <div class="col-4">
              <button type="button" class="btn btn-lg btn-warning btn-block tender-type" id="cash20">CASH $20</button>
            </div>
            <div class="col-4 ">
              <button type="button" class="btn btn-lg btn-warning btn-block tender-type" id="cash50">CASH $50</button>
            </div>
            <div class="col-4 ">
              <button type="button" class="btn btn-lg btn-warning btn-block tender-type" id="cash100">CASH $100</button>
            </div>
            <div class="col-4 ">
              <button type="button" class="btn btn-lg btn-warning btn-block tender-type" id="TAB1">TAB</button>
            </div>
            <div class="col-4 ">
              <button type="button" class="btn btn-lg btn-warning btn-block tender-type" style="border: 2px solid red;" id="HACKERS">HACKERS</button>
            </div>
           <div class="col-4 ">
              <button type="button" class="btn btn-lg btn-warning btn-block tender-type" id="voucher">VOUCHER</button>
            </div>
            <div class="col-4 ">
              <button type="button" class="btn btn-lg btn-success btn-block tender-type" style="border: 2px solid red;" id="cash">CASH</button>
            </div>
            <div class="col-4 ">
              <button type="button" class="btn btn-lg btn-primary btn-block tender-type"  id="card">CARD</button>
            </div>
            <div class="col-4 ">
              <button type="button" class="btn btn-lg btn-warning btn-block tender-type" id="mobile">MOBILE</button>
            </div>
            <div class="col-4 ">
              <button type="button" class="btn btn-lg btn-warning btn-block tender-type" id="direct">Direct</button>
            </div>
			<!--
             <div class="col-4 ">
              <button type="button" class="btn btn-lg btn-info btn-block tender-type" id="TAB2">GIFTCARD</button>
            </div>

            <div class="col-4 ">
              <button type="button" class="btn btn-lg btn-info btn-block tender-type" id="TAB2">TAB 2</button>
            </div>
			-->
          </div>
        </div>
		
    <script>
        function payWithMobile(amount) {
            var url = 'payment://new?amount='+ amount;
			//alert(url);
            window.location.href = url;
            // Alternatively, you can use window.open
            // window.open(url, '_self');
			document.getElementById('acknowledgeChangeButton').innerText = 'Approved?';
        }
    </script>
        

        <div class="form-group mt-3" id="changeAmountContainer">
          <!-- <label for="changeAmount">Change Amount</label> -->
          <p id="changeAmount" class="change-amount">0.00</p>
        </div>
      </div>
      <div id="pay-modal-footer" class="modal-footer">
	          <!-- Inside the Pay Modal -->
	    <div style="display:none;">
        <div id="tenderamount" class="form-group mt-3" style="display:none;">
          <label for="amount">Tender Amount</label>
          <input type="number" id="amount" class="form-control" value="0.00" min="0" step="0.01">
        </div>
	    </div>
        <button id="acknowledgeChangeButton" class="btn btn-success">OK</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<!-- Card Payment Modal -->
<div class="modal fade" id="cardPaymentModal" tabindex="-1" role="dialog" aria-labelledby="cardPaymentModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cardPaymentModalLabel">Card Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="cardTerminalResponse" class="form-group mt-3"> <!-- Added margin-top class -->
          Card Payment Terminal
        </div>
        <div class="success-tick"></div> <!-- Placed outside the cardTerminalResponse div -->
        <div id="spinner" class="spinner" ></div> <!-- Placed outside the cardTerminalResponse div -->
        <div id="errorContainer" class="error-container">
          <p id="errorMessage" class="error-message"></p>
          <button id="errorButton" class="error-button">OK</button>
        </div>
      </div>
      <div class="modal-footer">
		<button type="button" class="btn btn-danger" data-dismiss="modal" id="cancelTransactionButton">CANCEL</button>
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
      </div>
    </div>
  </div>
</div>


 <!-- Receipt Modal Structure -->
<div id="receiptModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">POS Print</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#receiptModal').hide();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe id="receiptIframe" style="width: 100%; height: 420px; border: none;"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="printReceipt">Print</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#receiptModal').hide();">Close</button>
                <button type="button" class="btn btn-success" id="emailReceipt">Email</button>
            </div>
        </div>
    </div>
</div>

<!-- Email Input Modal Structure -->
<div id="emailInputModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Send by Email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#emailInputModal').hide();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="emailForm">
                    <div class="form-group">
                        <label for="emailAddress">Email Address</label>
                        <input type="email" class="form-control" id="emailAddress" value="treasurer@coochiegolf.com.au" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id="clearEmail" onclick="clearEmailField();">Clear</button>
                <button type="button" class="btn btn-primary" id="sendEmail">Send</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#emailInputModal').hide();isModalOpen = false; focusOnDisplay();">Close</button>
            </div>
        </div>
    </div>
</div>



<script>
document.getElementById('generateReceipt').addEventListener('click', function() {
    generateReceipt(currentTransaction);
});



function generateReceipt(transaction) {
    fetch('./generate_receipts.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(transaction)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            openReceiptModal(data.receiptUrl);
        } else {
            console.error('Error generating receipt:', data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

function openReceiptModal(receiptUrl) {
    document.getElementById('receiptIframe').src = receiptUrl;
    document.getElementById('receiptModal').style.display = 'block';
}

document.getElementById('printReceipt').addEventListener('click', function() {
    let iframe = document.getElementById('receiptIframe');
    iframe.contentWindow.print();
});

document.getElementById('emailReceipt').addEventListener('click', function() {
	isModalOpen = true;
    document.getElementById('emailInputModal').style.display = 'block';
});

document.getElementById('sendEmail').addEventListener('click', function() {
    let iframe = document.getElementById('receiptIframe');
    let iframeDocument = iframe.contentDocument || iframe.contentWindow.document;
    let receiptHtml = iframeDocument.documentElement.outerHTML;

    let emailAddress = document.getElementById('emailAddress').value;

    let emailData = {
        to: emailAddress,
        from: 'assistant@retailcentral.com.au',
        subject: 'RetailCentral | POS Print',
        body: receiptHtml
    };
    
   // console.log('Receipt HTML:', receiptHtml);
    console.log('Sending Email request');
  //  console.log('Email Data:', JSON.stringify(emailData));

    fetch('https://finchcorp.supportoffice.com.au/admin/Process_Email_DIRECT.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(emailData)
    })
    .then(response => {
        console.log('Response received:', response);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.status === 'success') {
            alert('Email sent successfully.');
            document.getElementById('emailInputModal').style.display = 'none';
        } else {
            console.error('Error sending email:', data.message);
            alert('There was an error sending the email.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('There was an error sending the email.');
    });
});

function clearEmailField() {
    let emailField = document.getElementById('emailAddress');
	isModalOpen = true;
    emailField.focus();
    emailField.value = '';
	console.log("Email field cleared, await User input");
}

</script>


<!-- Footer -->
<div class="footer container-fluid">
    <div class="row">
        <div class="col text-center">
            <button class="btn btn-info btn-footer" id="pos-read-btn">POS Read</button>
        </div>
        <div class="col text-center">
            <button class="btn btn-info btn-footer" id="admin-btn-footer">Admin</button>
        </div>
        <div class="col text-center">
            <button class="btn btn-info btn-footer" id="logout-btn">Logout</button>
        </div>

    </div>
	     <div class="col text-right">
			<span id="focusedElement"></span>
            <span id="live-clock"></span>
        </div>
</div>

<script>
document.getElementById('pos-read-btn').addEventListener('click', function() {
    posRead();
});
</script>


<div id="fastkey-modal-detail" class="modal-product-detail">
  <div class="modal-content">
    <img id="product-img" src="" alt="Product Image" style="width: 100%; max-width: 100px;">
    <div id="product-info" style="display: inline-block; margin-left: 20px;">
      <h2 id="product-name"></h2>
      <p id="product-sell"></p>
      <p id="product-notes">
	  Tasting Notes:
 </p>
    </div>
    <button id="ok-button" class="btn btn-primary">OK</button>
    <button id="cancel-button" class="btn btn-primary">Cancel</button>
  </div>
</div>





  
  <!-- Include jQuery and Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<script type="text/javascript" src="main.js?ver=3.91"></script>

  <!-- <script src="https://pos.retailcentral.com.au/include/RetailCentral_POS_ver_1.9.js"></script> -->

  <script>
	window.addEventListener('DOMContentLoaded', (event) => {
    fetch('fastkeys.html')
    .then(response => response.text())
    .then(data => {
      document.getElementById('fast-keys-container').innerHTML = data;
    });
	});
	
	
	window.addEventListener('DOMContentLoaded', (event) => {
    fetch('taskkeys.html')
    .then(response => response.text())
    .then(data => {
      document.getElementById('task-keys-container').innerHTML = data;
    });
	});


if (navigator.windowControlsOverlay) {
  const overlayController = navigator.windowControlsOverlay;
  overlayController.ongeometrychange = () => {
    console.log('Window controls overlay geometry changed.');
  };
}

  </script>
  
 <div id="tabContainer">
    <div class="tab" id="quickNumbersTab" onclick="openTab('quickNumbersContainer')">Quick Numbers
	</div>
    <div class="slideout" id="quickNumbersContainer"><div id="quickNumbersContent"<h1>Quick Numbers</h1><div id="summary"></div></div>
	<button id="numbersReset" class="btn btn-danger" style="margin-top:15px; margin-left:15px;display:none;">Reset</button></div>

    <div class="tab" id="communicationsTab" onclick="openTab('communicationsContent')">Messages</div>
    <div class="slideout" id="communicationsContent"><h1>Messages</h1></div>

    <div class="tab" id="taskListTab" onclick="openTab('taskListContent')">Tasks</div>
    <div class="slideout" id="taskListContent">
	<h1>Tasks</h1>
	<div id="task-keys-container" ></div>
	        <div class="col text-center">
            <button class="btn btn-danger btn-footer" id="rebootButton" onclick="reboot();">Reload App</button>
        </div>
	<div id="task-keys-sundry"><img id="qrPOS" src="images/qr_pos_golf.png" style="margin-left:40px;"/></div>
	</div>
</div>
  
<!-- Numbers Reset Modal Structure -->
<div id="confirmModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Reset</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to reset all transactions data?</p>
      </div>
      <div class="modal-footer">
        <button type="button" id="confirmYes" class="btn btn-danger">Yes</button>
        <button type="button" id="confirmNo" class="btn btn-secondary" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>

  
<script type="text/javascript" src="fastkeys.js"></script>

<script>
document.getElementById('numbersReset').addEventListener('click', function() {
    // Show the modal
    document.getElementById('confirmModal').style.display = 'block';
});

document.getElementById('confirmNo').addEventListener('click', function() {
    // Hide the modal
    document.getElementById('confirmModal').style.display = 'none';
});

document.getElementById('confirmYes').addEventListener('click', function() {
    // Hide the modal
    document.getElementById('confirmModal').style.display = 'none';
    // Delete transactions
    deleteTransactions();
});

function deleteTransactions() {
    let request = indexedDB.open("posDB", 3);

    request.onsuccess = function(event) {
        let db = event.target.result;
        let transaction = db.transaction(["transactions"], "readwrite");
        let objectStore = transaction.objectStore("transactions");
        
        let objectStoreRequest = objectStore.clear();
        
        objectStoreRequest.onsuccess = function(event) {
            console.log("All transactions have been deleted.");
            // Optionally, you can add code here to update the UI to reflect the cleared data.
        };
        
        objectStoreRequest.onerror = function(event) {
            console.error("Error deleting transactions:", event.target.error);
        };
    };

    request.onerror = function(event) {
        console.error("Error opening database:", event.target.error);
    };
}


async function eod() {
  document.getElementById('confirmModal').style.display = 'block';
}


async function processTask(event) {
    var taskValue = event.target.getAttribute('data-value');
    console.log("Task Value: " + taskValue); // Debugging line

    switch (taskValue) {
        case 'item':
            console.log("Client-side: Adding Item");
            // Add your client-side logic here
            window.open('https://coochiegolf.clubconnect.org.au/admin/LocationItem_list.php?q=(LocationID~equals~1000140)&f=all&tab=', '_blank');
            break;
        case 'barcode':
            console.log("Client-side: Adding Barcode");
            // Add your client-side logic here
            window.open('https://coochiegolf.clubconnect.org.au/admin/LocationItem_list.php?q=(LocationID~equals~1000140)&f=all&tab=', '_blank');
            break;
        case 'price':
            console.log("Client-side: Changing Price");
            // Add your client-side logic here
            window.open('https://coochiegolf.clubconnect.org.au/admin/LocationItem_list.php?q=(LocationID~equals~1000140)&f=all&tab=', '_blank');
            break;
        case 'promo':
            console.log("Client-side: Starting Promo");
            // Add your client-side logic here
            await sendToServer(taskValue);
            break;
        case 'mobile':
            console.log("Client-side: Going Mobile");
            // Add your client-side logic here
            await sendToServer(taskValue);
            break;
        case 'product':
            console.log("Client-side: Update Products");
            // Add your client-side logic here
            await sendToServer(taskValue);
			alert("Request sent to Server");
            break;
        case 'help':
            alert("Assistance Called by SMS");
            console.log("Client-side: Calling HELP");
            // Add your client-side logic here
            await sendToServer(taskValue);
            break;
		case 'eod' :
		    eod();
			break;
        case 'openPage':
            console.log("Client-side: Opening Web Page");
            window.location.href = 'https://www.example.com'; // URL of the web page to open
            break;
        default:
            console.log("Client-side: Unknown Task");
            // Add your client-side logic here
            break;
    }
}

async function sendToServer(taskValue) {
    try {
        const response = await fetch('processTask.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({ task: taskValue })
        });

        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }

        const serverResponse = await response.text();
        console.log("Server Response: " + serverResponse);
        // Handle the response from the server

    } catch (error) {
        console.error('Fetch error: ', error);
    }
}

        function showMobileQR() {
            document.getElementById('qrPOS').style.display = 'block';
        }
</script>


</body>

</html>
