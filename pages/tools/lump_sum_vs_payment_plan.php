<?php $title = 'Lump Sum vs Payment Plan Calculator'; ?>
<?php $body = <<<HTML

<div class="column">
    <form class="calculator">
        <h2>Lump Sum vs Payment Plan</h2>
        <p>Use this calculator to see how the interest income on a lump sum investment would offset the cost of a payment plan.</p>
        <div class="form-section">
            <label for="principal">Principal Amount ($):</label>
            <input type="number" id="principal" name="principal" value="28000" />
            <div class="note">This is the lump sum you would pay.</div>
        </div>
        <div class="form-section">
            <label for="interestRate">Estimated APY (%):</label>
            <input type="number" id="interestRate" name="interestRate" step="0.1" value="3.1" />
            <div class="note">This is the estimated annual percentage yield if you kept the principal invested.</div>
        </div>
        <div class="form-section">
            <label for="payments">Number of Payments:</label>
            <input type="number" id="payments" name="payments" value="4" />
            <div class="note">This is the total number of payments you would make.</div>
        </div>
        <div class="form-section">
            <label for="months">Payments made every # months:</label>
            <input type="number" id="months" name="months" value="3" />
            <div class="note">This is the interval in months between each payment.</div>
        </div>
        <div class="form-section">
            <label for="planFee">Payment Plan Fee ($):</label>
            <input type="number" id="planFee" name="planFee" value="360" />
            <div class="note">This is the additional amount you would pay for the payment plan.</div>
        </div>
        <div class="form-section">
            <label for="planInterestRate">Payment Plan Interest Rate (%):</label>
            <input type="number" id="planInterestRate" name="planInterestRate" value="0.0" step="0.1" />
            <div class="note">This is the interest rate applied to the payment plan.</div>
        </div>
        <div class="form-section">
            <label for="compoundInterest">Interest Compounds Monthly:</label>
            <select id="compoundInterest" name="compoundInterest">
                <option value="yes" selected>Yes</option>
                <option value="no">No</option>
            </select>
        </div>
        <button type="submit">
            <span class="text">Calculate</span>
            <div class="spinner hide" role="status" aria-label="Loading"></div>
        </button>
    </form>
</div>
<div class="column">
    <div id="calculatorResults" class="calculator-results"></div>
</div>
<div style="clear:both"></div>

<script>
function calculatePaymentPlan() {
    const principal = parseFloat(document.getElementById('principal').value);
    const interestRate = parseFloat(document.getElementById('interestRate').value) / 100;
    const payments = parseInt(document.getElementById('payments').value);
    const months = parseInt(document.getElementById('months').value);
    const planFee = parseFloat(document.getElementById('planFee').value);
    const planInterestRate = parseFloat(document.getElementById('planInterestRate').value) / 100;
    const totalPlanInterest = (principal * (planInterestRate / 12) * months * payments);
    const totalPaymentPlanCost = principal + planFee + totalPlanInterest;
    const paymentAmount = totalPaymentPlanCost / payments;

    var calculatorResultsElement = document.getElementById('calculatorResults');
    var planBalance = totalPaymentPlanCost
    var principalBalance = principal;

    calculatorResultsElement.innerHTML = `<h2>Payment Plan</h2>`;

    // Make payments and calculate interest
    var currentPayment = 0;
    var currentPrincipalInterest = 0;
    var totalPrincipalInterest = 0;
    while(payments > currentPayment) {
        currentPayment++;
        totalPrincipalInterest += currentPrincipalInterest;
        if(document.getElementById('compoundInterest').value === 'yes') {
            principalBalance += currentPrincipalInterest;
        }
        planBalance -= paymentAmount;
        principalBalance -= paymentAmount;
        currentPrincipalInterest = (principalBalance * (interestRate / 12)) * months;
        
        var element = document.createElement('p');
        element.innerHTML = 'Payment ' + currentPayment + ': $' + paymentAmount.toFixed(2) + '<br />Remaining Plan Balance: $' + planBalance.toFixed(2) + '<br />Remaining Principal Balance: $' + principalBalance.toFixed(2) + '<br />Interest this period: $' + currentPrincipalInterest.toFixed(2);
        calculatorResultsElement.appendChild(element);
    }
    var totalCostElement = document.createElement('p');
    totalCostElement.innerHTML = 'Total Cost of Payment Plan<br />$' + totalPaymentPlanCost.toFixed(2);
    calculatorResultsElement.appendChild(totalCostElement);
    var paymentPlanFeeElement = document.createElement('p');
    paymentPlanFeeElement.innerHTML = 'Payment Plan Fee<br />$' + planFee.toFixed(2);
    calculatorResultsElement.appendChild(paymentPlanFeeElement);
    var totalInterestPaidElement = document.createElement('p');
    totalInterestPaidElement.innerHTML = 'Payment Plan Interest Paid<br />$' + totalPlanInterest.toFixed(2);
    calculatorResultsElement.appendChild(totalInterestPaidElement);
    var totalInterestElement = document.createElement('p');
    totalInterestElement.innerHTML = 'Total Interest Earned<br />$' + totalPrincipalInterest.toFixed(2);
    calculatorResultsElement.appendChild(totalInterestElement);
    var netCostElement = document.createElement('p');
    netCostElement.innerHTML = 'Net Profit/Loss of Payment Plan<br />$' + (principal + totalPrincipalInterest - totalPaymentPlanCost).toFixed(2);
    calculatorResultsElement.appendChild(netCostElement);
}
document.querySelector('.calculator').addEventListener('submit', function(event) {
    event.preventDefault();
    document.querySelector('.calculator button[type="submit"] .text').classList.add('hide');
    document.querySelector('.calculator button[type="submit"] .spinner').classList.remove('hide');
    setTimeout(function() {
        calculatePaymentPlan();
        document.querySelector('.calculator button[type="submit"] .text').classList.remove('hide');
        document.querySelector('.calculator button[type="submit"] .spinner').classList.add('hide');
    }, 500);
    
    
});
</script>

HTML;
?>