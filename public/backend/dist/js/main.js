
function step1(){
	$("#error-div").addClass('display-none');
var product_id = $.trim($("#product-id").val());
var errorSection = document.getElementById("js-errors");
var minPlacementAmount = $.trim($('#minimum-placement-amount').val());
errorSection.innerHTML = '';
var formula = $.trim($('#formula').val());
var errors = new Array();
var i = 0;
var LOAN = ['<?php echo LOAN_F1; ?>'];
var FDP1 = ['<?php echo FIX_DEPOSIT_F1; ?>', '<?php echo PRIVILEGE_DEPOSIT_F6; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F1; ?>'];
var SDP3 = ['<?php echo SAVING_DEPOSIT_F3; ?>', '<?php echo PRIVILEGE_DEPOSIT_F3; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F4; ?>'];
var SDP5 = ['<?php echo SAVING_DEPOSIT_F5; ?>', '<?php echo PRIVILEGE_DEPOSIT_F5; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F6; ?>'];
var SDP1 = [
'<?php echo SAVING_DEPOSIT_F1; ?>', '<?php echo SAVING_DEPOSIT_F2; ?>',
'<?php echo PRIVILEGE_DEPOSIT_F1; ?>', '<?php echo PRIVILEGE_DEPOSIT_F2; ?>',
'<?php echo FOREIGN_CURRENCY_DEPOSIT_F2; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F3; ?>'
];
var utilFormula = [
'<?php echo SAVING_DEPOSIT_F1; ?>',
'<?php echo PRIVILEGE_DEPOSIT_F1; ?>',
'<?php echo FOREIGN_CURRENCY_DEPOSIT_F2; ?>'
];
var SDP6 = [
'<?php echo SAVING_DEPOSIT_F4; ?>', '<?php echo PRIVILEGE_DEPOSIT_F4; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F5; ?>'
];
var AIOA = ['<?php echo ALL_IN_ONE_ACCOUNT_F1; ?>', '<?php echo ALL_IN_ONE_ACCOUNT_F2; ?>', '<?php echo ALL_IN_ONE_ACCOUNT_F3; ?>', '<?php echo ALL_IN_ONE_ACCOUNT_F4; ?>', '<?php echo ALL_IN_ONE_ACCOUNT_F5; ?>'];

var name = $.trim($('#name').val());
var bank = $.trim($('#bank').val());
var ongoingStatus = $.trim($('#ongoing-status-1').data('status'));
var productType = $.trim($('#product-type').val());
var currency = $.trim($('#currency').val());
var minimumLoanAmount = $.trim($('#minimum-loan-amount').val());
var maxInterestRate = $.trim($('#maximum-interest-rate').val());
var lockIn = $.trim($('#lock-in').val());
var promotionPeriod = $.trim($('#promotion-period').val());
var untilEndDate = $.trim($('#until-end-date').val());
var startDate = $.trim($('#promotion_start_date').val());
var endDate = $.trim($('#promotion_end_date').val());
// Make sure we entered the name
if (!name) {
errors[i] = 'The name is required.';
i++;
} else {
$.ajax({
method: "POST",
url: "{{url('/admin/check-product')}}",
data: {
name: name,
product_id: product_id,
bank: bank,
productType: productType,
formula: formula
},
cache: false,
async: false,
success: function (data) {
console.log(data);
if (data == 1) {
errors[i] = 'This detail has already been taken';
i++;
}
}
});
}
if (!bank) {
errors[i] = 'The bank is required.';
i++;
}
if (!productType) {
errors[i] = 'The product type is required.';
i++;
}
if (!(!startDate && !endDate) && (!startDate || !endDate)) {
errors[i] = 'The date is required.';
i++;
}
if ((jQuery.inArray(formula, LOAN) !== -1) || (productType == '<?php echo LOAN ;?>')) {
/*if (!maxInterestRate) {
errors[i] = 'The interest rate is required.';
i++;
}*/
if (!lockIn) {
errors[i] = 'The lock in is required.';
i++;
}
if (!minimumLoanAmount) {
errors[i] = 'The minumum loan amount is required.';
i++;
}
} else {
if (!minPlacementAmount && (jQuery.inArray(formula, AIOA) !== -1)) {
errors[i] = 'The maximum placement is required.';
i++;
}
else if (!minPlacementAmount) {
errors[i] = 'The minimum placement is required.';
i++;
}
if (!maxInterestRate) {
errors[i] = 'The maximum interest rate is required.';
i++;
}
if ((!promotionPeriod) && (jQuery.inArray(formula, AIOA) !== -1)) {
errors[i] = 'The criteria is required.';
i++;
}
else if ((!promotionPeriod) && (ongoingStatus == 'false') && (jQuery.inArray(formula, utilFormula) === -1)) {
errors[i] = 'The promotion period is required.';
i++;
}
}
if ((!untilEndDate) && (jQuery.inArray(formula, utilFormula) !== -1) && (ongoingStatus == 'false')) {
errors[i] = 'The until end date is required.';
i++;
}
if (errors.length) {
$("#error-div").removeClass('display-none');
$.each(errors, function (k, v) {
errorSection.innerHTML = errorSection.innerHTML + '<p>' + v + '</p>';
});
return false;
}

function step2(){
$("#error-div").addClass('display-none');
var product_id = $.trim($("#product-id").val());
var errorSection = document.getElementById("js-errors");
var minPlacementAmount = $.trim($('#minimum-placement-amount').val());
errorSection.innerHTML = '';
var formula = $.trim($('#formula').val());
var errors = new Array();
var i = 0;
var LOAN = ['<?php echo LOAN_F1; ?>'];
var FDP1 = ['<?php echo FIX_DEPOSIT_F1; ?>', '<?php echo PRIVILEGE_DEPOSIT_F6; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F1; ?>'];
var SDP3 = ['<?php echo SAVING_DEPOSIT_F3; ?>', '<?php echo PRIVILEGE_DEPOSIT_F3; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F4; ?>'];
var SDP5 = ['<?php echo SAVING_DEPOSIT_F5; ?>', '<?php echo PRIVILEGE_DEPOSIT_F5; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F6; ?>'];
var SDP1 = [
'<?php echo SAVING_DEPOSIT_F1; ?>', '<?php echo SAVING_DEPOSIT_F2; ?>',
'<?php echo PRIVILEGE_DEPOSIT_F1; ?>', '<?php echo PRIVILEGE_DEPOSIT_F2; ?>',
'<?php echo FOREIGN_CURRENCY_DEPOSIT_F2; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F3; ?>'
];
var utilFormula = [
'<?php echo SAVING_DEPOSIT_F1; ?>',
'<?php echo PRIVILEGE_DEPOSIT_F1; ?>',
'<?php echo FOREIGN_CURRENCY_DEPOSIT_F2; ?>'
];
var SDP6 = [
'<?php echo SAVING_DEPOSIT_F4; ?>', '<?php echo PRIVILEGE_DEPOSIT_F4; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F5; ?>'
];
var AIOA = ['<?php echo ALL_IN_ONE_ACCOUNT_F1; ?>', '<?php echo ALL_IN_ONE_ACCOUNT_F2; ?>', '<?php echo ALL_IN_ONE_ACCOUNT_F3; ?>', '<?php echo ALL_IN_ONE_ACCOUNT_F4; ?>', '<?php echo ALL_IN_ONE_ACCOUNT_F5; ?>'];

var productType = $.trim($('#product-type').val());
var currency = $.trim($('#currency').val());
if ((productType == '<?php echo FOREIGN_CURRENCY_DEPOSIT ;?>') && (currency.length == 0)) {
errors[i] = 'The currency type is required.';
i++;
}
if (jQuery.inArray(formula, FDP1) !== -1) {
var minPlacements = $('#fixDepositF1').find('input[name^="min_placement"]').map(function () {
return $.trim($(this).val());
}).get();
var maxPlacements = $('#fixDepositF1').find('input[name^="max_placement"]').map(function () {
return $.trim($(this).val());
}).get();
var tenures = $('#fixDepositF1').find('input[name^="tenure[0]"]').map(function () {
return $.trim($(this).val());
}).get();
var interests = $('#fixDepositF1').find('input[name^="bonus_interest"]').map(function () {
return $.trim($(this).val());
}).get();
var tenureError = false;
var rangeError = false;
$.each(minPlacements, function (k, v) {
if (minPlacements[k] == '' || maxPlacements[k] == '') {
errors[i] = 'The placement range is required.';
i++;
return false;
}
});
$.each(tenures, function (k, v) {
if (tenures[k] == '') {
errors[i] = 'The tenure is required.';
i++;
tenureError = true;
return false;
}
});
$.each(interests, function (k, v) {
if (interests[k] == '') {
errors[i] = 'The bonus interest is required.';
i++;
return false;
}
});
$.each(minPlacements, function (k, v) {
if (Number(v) < Number(minPlacementAmount)) {
errors[i] = 'All placement must be greater than or equal to minimum placement amount.';
i++;
return false;
}
if (Number(maxPlacements[k]) < Number(minPlacementAmount)) {
errors[i] = 'All placement must be greater than or equal to minimum placement amount.';
i++;
return false;
}
});
}
if (jQuery.inArray(formula, SDP1) !== -1) {
var minPlacements = $('#savingDepositF1').find('input[name^="min_placement_sdp1"]').map(function () {
return $.trim($(this).val());
}).get();
var maxPlacements = $('#savingDepositF1').find('input[name^="max_placement_sdp1"]').map(function () {
return $.trim($(this).val());
}).get();
var bonusInterest = $('#savingDepositF1').find('input[name^="bonus_interest_sdp1"]').map(function () {
return $.trim($(this).val());
}).get();
var boardInterest = $('#savingDepositF1').find('input[name^="board_rate_sdp1"]').map(function () {
return $.trim($(this).val());
}).get();
var tenureError = false;
var rangeError = false;
$.each(minPlacements, function (k, v) {
if (minPlacements[k] == '' || maxPlacements[k] == '') {
errors[i] = 'The placement range is required.';
i++;
return false;
}
});
$.each(bonusInterest, function (k, v) {
if (bonusInterest[k] == '') {
errors[i] = 'The bonus interest is required.';
i++;
return false;
}
});
$.each(boardInterest, function (k, v) {
if (boardInterest[k] == '') {
errors[i] = 'The board interest is required.';
i++;
return false;
}
});
if (formula == '<?php echo SAVING_DEPOSIT_F2; ?>') {
var tenure = $('#savingDepositF1').find('input[name="tenure_sdp1"]').map(function () {
return $.trim($(this).val());
}).get();
if (tenure == '') {
errors[i] = 'The tenure is required.';
i++;
}
}
if (rangeError == false) {
$.ajax({
method: "POST",
url: "{{url('/admin/check-range')}}",
data: {max_placement: maxPlacements, min_placement: minPlacements},
cache: false,
async: false,
success: function (data) {
if (data == 1) {
errors[i] = 'Please check your placement range ';
i++;
}
if (data == 2) {
errors[i] = 'Max Placement must be greater than Min Placement';
i++;
}
}
});
}
$.each(minPlacements, function (k, v) {
if (Number(v) < Number(minPlacementAmount)) {
errors[i] = 'All placement must be greater than or equal to minimum placement amount.';
i++;
return false;
}
if (Number(maxPlacements[k]) < Number(minPlacementAmount)) {
errors[i] = 'All placement must be greater than or equal to minimum placement amount.';
i++;
return false;
}
});
}
if (jQuery.inArray(formula, SDP6) !== -1) {
var maxPlacements = $('#savingDepositF4').find('input[name^="max_placement_sdp4"]').map(function () {
return $.trim($(this).val());
}).get();
var bonusInterest = $('#savingDepositF4').find('input[name^="bonus_interest_sdp4"]').map(function () {
return $.trim($(this).val());
}).get();
var boardInterest = $('#savingDepositF4').find('input[name^="board_rate_sdp4"]').map(function () {
return $.trim($(this).val());
}).get();
var rangeError = false;
$.each(maxPlacements, function (k, v) {
if (maxPlacements[k] == '') {
errors[i] = 'The placement is required.';
i++;
return false;
}
});
$.each(bonusInterest, function (k, v) {
if (bonusInterest[k] == '') {
errors[i] = 'The bonus interest is required.';
i++;
return false;
}
});
$.each(boardInterest, function (k, v) {
if (boardInterest[k] == '') {
errors[i] = 'The board interest is required.';
i++;
return false;
}
});
}
if (jQuery.inArray(formula, SDP3) !== -1) {
var minPlacement = $('#savingDepositF3').find('input[name="min_placement_sdp3"]').map(function () {
return $.trim($(this).val());
}).get();
var maxPlacement = $('#savingDepositF3').find('input[name="max_placement_sdp3"]').map(function () {
return $.trim($(this).val());
}).get();
var averageInterestRate = $('#savingDepositF3').find('input[name="air_sdp3"]').map(function () {
return $.trim($(this).val());
}).get();
var siborRate = $('#savingDepositF3').find('input[name="sibor_rate_sdp3"]').map(function () {
return $.trim($(this).val());
}).get();
if (minPlacement == '' || maxPlacement == '' || ( parseInt(minPlacement) > parseInt(maxPlacement))) {
errors[i] = 'Please check your placement range. ';
i++;
}
if (averageInterestRate == '') {
errors[i] = 'The average interest rate is required.';
i++;
}
if (siborRate == '') {
errors[i] = 'The sibor rate is required.';
i++;
}
if (Number(minPlacement) < Number(minPlacementAmount) || Number(maxPlacement) < Number(minPlacementAmount)) {
errors[i] = 'All placement must be greater than or equal minimum placement amount.';
i++;
}
}
if (jQuery.inArray(formula, SDP5) !== -1) {
var minPlacement = $('#savingDepositF5').find('input[name="min_placement_sdp5"]').map(function () {
return $.trim($(this).val());
}).get();
var maxPlacement = $('#savingDepositF5').find('input[name="max_placement_sdp5"]').map(function () {
return $.trim($(this).val());
}).get();
var baseInterest = $('#savingDepositF5').find('input[name="base_interest_sdp5"]').map(function () {
return $.trim($(this).val());
}).get();
var bonusInterest = $('#savingDepositF5').find('input[name="bonus_interest_sdp5"]').map(function () {
return $.trim($(this).val());
}).get();
var placementMonth = $('#savingDepositF5').find('input[name="placement_month_sdp5"]').map(function () {
return $.trim($(this).val());
}).get();
var displayMonth = $('#savingDepositF5').find('input[name="display_month_sdp5"]').map(function () {
return $.trim($(this).val());
}).get();
if (minPlacement == '' || maxPlacement == '' || ( parseInt(minPlacement) > parseInt(maxPlacement))) {
errors[i] = 'Please check your placement range. ';
i++;
}
if (baseInterest == '') {
errors[i] = 'The base interest rate is required.';
i++;
}
if (bonusInterest == '') {
errors[i] = 'The bonus interest is required.';
i++;
}
if (placementMonth == '') {
errors[i] = 'The placement month is required.';
i++;
}
if (displayMonth == '') {
errors[i] = 'The display month is required.';
i++;
}
if (parseInt(displayMonth) > parseInt(placementMonth)) {
errors[i] = 'The display month interval is not greater than placement month.';
i++;
}
if (Number(minPlacement) < Number(minPlacementAmount) || Number(maxPlacement) < Number(minPlacementAmount)) {
errors[i] = 'All placement must be greater than or equal minimum placement amount.';
i++;
}
}
if (formula == 7) {
var allInOneAccountF1 = $('#allInOneAccountF1');
var minPlacement = allInOneAccountF1.find('input[name="min_placement_aioa1"]').map(function () {
return $.trim($(this).val());
}).get();
var maxPlacement = allInOneAccountF1.find('input[name="max_placement_aioa1"]').map(function () {
return $.trim($(this).val());
}).get();
var SalaryMinAmount = allInOneAccountF1.find('input[name="minimum_salary_aioa1"]').map(function () {
return $.trim($(this).val());
}).get();
var SalaryBonusInterest = allInOneAccountF1.find('input[name="bonus_interest_salary_aioa1"]').map(function () {
return $.trim($(this).val());
}).get();
var GiroMinAmount = allInOneAccountF1.find('input[name="minimum_giro_payment_aioa1"]').map(function () {
return $.trim($(this).val());
}).get();
var GiroBonusInterest = allInOneAccountF1.find('input[name="bonus_interest_giro_payment_aioa1"]').map(function () {
return $.trim($(this).val());
}).get();
var SpendMinAmount = allInOneAccountF1.find('input[name="minimum_spend_aioa1"]').map(function () {
return $.trim($(this).val());
}).get();
var SpendBonusInterest = allInOneAccountF1.find('input[name="bonus_interest_spend_aioa1"]').map(function () {
return $.trim($(this).val());
}).get();
var PrivilegeMinAmount = allInOneAccountF1.find('input[name="minimum_privilege_pa_aioa1"]').map(function () {
return $.trim($(this).val());
}).get();
var PrivilegeBonusInterest = allInOneAccountF1.find('input[name="bonus_interest_privilege_aioa1"]').map(function () {
return $.trim($(this).val());
}).get();
/*var LoanMinAmount = allInOneAccountF1.find('input[name="minimum_loan_pa_aioa1"]').map(function () {
return $.trim($(this).val());
}).get();
var LoanBonusInterest = allInOneAccountF1.find('input[name="bonus_interest_loan_aioa1"]').map(function () {
return $.trim($(this).val());
}).get();*/
var BonusAmount = allInOneAccountF1.find('input[name="minimum_bonus_aioa1"]').map(function () {
return $.trim($(this).val());
}).get();
var BonusInterest = allInOneAccountF1.find('input[name="bonus_interest_bonus_aioa1"]').map(function () {
return $.trim($(this).val());
}).get();
var FirstCapAmount = allInOneAccountF1.find('input[name="first_cap_amount_aioa1"]').map(function () {
return $.trim($(this).val());
}).get();
var RemainingBonusInterest = allInOneAccountF1.find('input[name="bonus_interest_remaining_amount_aioa1"]').map(function () {
return $.trim($(this).val());
}).get();
if (Number(minPlacement) > Number(minPlacementAmount) || Number(maxPlacement) > Number(minPlacementAmount)) {
errors[i] = 'All placement must be less than or equal maximum placement amount.';
i++;
}
if (minPlacement == '' || maxPlacement == '' || ( parseInt(minPlacement) > parseInt(maxPlacement))) {
errors[i] = 'Please check your placement range. ';
i++;
}
if (SalaryMinAmount == '') {
errors[i] = 'The minimum requirement amount (Salary) is required.';
i++;
}
if (SalaryBonusInterest == '') {
errors[i] = 'The  bonus interest (Salary) is required.';
i++;
}
if (GiroMinAmount == '') {
errors[i] = 'The minimum requirement amount (Giro) is required.';
i++;
}
if (GiroBonusInterest == '') {
errors[i] = 'The  bonus interest (Giro) is required.';
i++;
}
if (SpendMinAmount == '') {
errors[i] = 'The minimum requirement amount (Spend) is required.';
i++;
}
if (SpendBonusInterest == '') {
errors[i] = 'The  bonus interest (Spend) is required.';
i++;
}
if (PrivilegeMinAmount == '') {
errors[i] = 'The minimum requirement amount (Privilege) is required.';
i++;
}
if (PrivilegeBonusInterest == '') {
errors[i] = 'The  bonus interest (Privilege) is required.';
i++;
}
if (BonusAmount == '') {
errors[i] = 'The  first cap amount is required.';
i++;
}
if (BonusInterest == '') {
errors[i] = 'The  bonus interest (First cap) is required.';
i++;
}
if (FirstCapAmount == '') {
errors[i] = 'The  first cap amount is required.';
i++;
}
if (RemainingBonusInterest == '') {
errors[i] = 'The  bonus interest (Remaining) is required.';
i++;
}
if (parseInt(minPlacement) > parseInt(FirstCapAmount)) {
errors[i] = 'The  first cap amount  is not greater than minimum placement.';
i++;
}
}
if (formula == 8) {
var allInOneAccountF2 = $('#allInOneAccountF2');
var SpendMinAmount = allInOneAccountF2.find('input[name="minimum_spend_aioa2"]').map(function () {
return $.trim($(this).val());
}).get();
var GiroMinAmount = allInOneAccountF2.find('input[name="minimum_giro_payment_aioa2"]').map(function () {
return $.trim($(this).val());
}).get();
var SalaryMinAmount = allInOneAccountF2.find('input[name="minimum_salary_aioa2"]').map(function () {
return $.trim($(this).val());
}).get();
var maxPlacements = allInOneAccountF2.find('input[name^="max_placement_aioa2"]').map(function () {
return $.trim($(this).val());
}).get();
var bonusInterestA = allInOneAccountF2.find('input[name^="bonus_interest_criteria_a_aioa2"]').map(function () {
return $.trim($(this).val());
}).get();
var bonusInterestB = allInOneAccountF2.find('input[name^="bonus_interest_criteria_b_aioa2"]').map(function () {
return $.trim($(this).val());
}).get();
var rangeError = false;
if (SpendMinAmount == '') {
errors[i] = 'The minimum requirement amount (Spend) is required.';
i++;
}
if (GiroMinAmount == '') {
errors[i] = 'The minimum requirement amount (Giro) is required.';
i++;
}
if (SalaryMinAmount == '') {
errors[i] = 'The minimum requirement amount (Salary) is required.';
i++;
}
$.each(maxPlacements, function (k, v) {
if (maxPlacements[k] == '') {
errors[i] = 'The placement is required.';
i++;
rangeError = true;
return false;
}
});
$.each(bonusInterestA, function (k, v) {
if (bonusInterestA[k] == '') {
errors[i] = 'The bonus interest (A) is required.';
i++;
return false;
}
});
$.each(bonusInterestB, function (k, v) {
if (bonusInterestB[k] == '') {
errors[i] = 'The bonus interest (B) is required.';
i++;
return false;
}
});
var minPlacements = [];
var min = 0;
$.each(maxPlacements, function (k, v) {
minPlacements[k] = Number(min);
min = Number(v) + Number(1);
});
}
if (formula == 9) {
var allInOneAccountF3 = $('#allInOneAccountF3');
var minPlacement = allInOneAccountF3.find('input[name="min_placement_aioa3"]').map(function () {
return $.trim($(this).val());
}).get();
var maxPlacement = allInOneAccountF3.find('input[name="max_placement_aioa3"]').map(function () {
return $.trim($(this).val());
}).get();
var SalaryMinAmount = allInOneAccountF3.find('input[name="minimum_salary_aioa3"]').map(function () {
return $.trim($(this).val());
}).get();
var GiroMinAmount = allInOneAccountF3.find('input[name="minimum_giro_payment_aioa3"]').map(function () {
return $.trim($(this).val());
}).get();
var SpendMinAmount = allInOneAccountF3.find('input[name="minimum_spend_aioa3"]').map(function () {
return $.trim($(this).val());
}).get();
var HirePurchaseMinAmount = allInOneAccountF3.find('input[name="minimum_hire_purchase_loan_aioa3"]').map(function () {
return $.trim($(this).val());
}).get();
var RenovationMinAmount = allInOneAccountF3.find('input[name="minimum_renovation_loan_aioa3"]').map(function () {
return $.trim($(this).val());
}).get();
var HomeMinAmount = allInOneAccountF3.find('input[name="minimum_home_loan_aioa3"]').map(function () {
return $.trim($(this).val());
}).get();
var EducationMinAmount = allInOneAccountF3.find('input[name="minimum_education_loan_aioa3"]').map(function () {
return $.trim($(this).val());
}).get();
var InsuranceMinAmount = allInOneAccountF3.find('input[name="minimum_insurance_aioa3"]').map(function () {
return $.trim($(this).val());
}).get();
var UnitTrustMinAmount = allInOneAccountF3.find('input[name="minimum_unit_trust_aioa3"]').map(function () {
return $.trim($(this).val());
}).get();
var RequirementCriteria1 = allInOneAccountF3.find('input[name="requirement_criteria1_aioa3"]').map(function () {
return $.trim($(this).val());
}).get();
var RequirementCriteria2 = allInOneAccountF3.find('input[name="requirement_criteria2_aioa3"]').map(function () {
return $.trim($(this).val());
}).get();
var RequirementCriteria3 = allInOneAccountF3.find('input[name="requirement_criteria3_aioa3"]').map(function () {
return $.trim($(this).val());
}).get();
var BonusInterestCriteria1 = allInOneAccountF3.find('input[name="bonus_interest_criteria1_aioa3"]').map(function () {
return $.trim($(this).val());
}).get();
var BonusInterestCriteria2 = allInOneAccountF3.find('input[name="bonus_interest_criteria2_aioa3"]').map(function () {
return $.trim($(this).val());
}).get();
var BonusInterestCriteria3 = allInOneAccountF3.find('input[name="bonus_interest_criteria3_aioa3"]').map(function () {
return $.trim($(this).val());
}).get();
var FirstCapAmount = allInOneAccountF3.find('input[name="first_cap_amount_aioa3"]').map(function () {
return $.trim($(this).val());
}).get();
var RemainingBonusInterest = allInOneAccountF3.find('input[name="bonus_interest_remaining_amount_aioa3"]').map(function () {
return $.trim($(this).val());
}).get();
if (Number(minPlacement) > Number(minPlacementAmount) || Number(maxPlacement) > Number(minPlacementAmount)) {
errors[i] = 'All placement must be less than or equal maximum placement amount.';
i++;
}
if (minPlacement == '' || maxPlacement == '' || ( parseInt(minPlacement) > parseInt(maxPlacement))) {
errors[i] = 'Please check your placement range. ';
i++;
}
if (SalaryMinAmount == '') {
errors[i] = 'The minimum requirement amount (Salary) is required.';
i++;
}
if (GiroMinAmount == '') {
errors[i] = 'The minimum requirement amount (Giro) is required.';
i++;
}
if (SpendMinAmount == '') {
errors[i] = 'The minimum requirement amount (Spend) is required.';
i++;
}
if (HirePurchaseMinAmount == '') {
errors[i] = 'The minimum requirement amount (Hire Purchase Loan) is required.';
i++;
}
if (RenovationMinAmount == '') {
errors[i] = 'The minimum requirement amount (Renovation Loan) is required.';
i++;
}
if (HomeMinAmount == '') {
errors[i] = 'The minimum requirement amount (Home Loan) is required.';
i++;
}
if (EducationMinAmount == '') {
errors[i] = 'The minimum requirement amount (Education Loan) is required.';
i++;
}
if (InsuranceMinAmount == '') {
errors[i] = 'The minimum requirement amount (Insurance Loan) is required.';
i++;
}
if (UnitTrustMinAmount == '') {
errors[i] = 'The minimum requirement amount (Unit Trust Loan) is required.';
i++;
}
if (RequirementCriteria1 == '') {
errors[i] = 'The number of criteria (Criteria 1) is required.';
i++;
}
if (RequirementCriteria2 == '') {
errors[i] = 'The number of criteria (Criteria 2) is required.';
i++;
}
if (RequirementCriteria3 == '') {
errors[i] = 'The number of criteria (Criteria 3) is required.';
i++;
}
if (BonusInterestCriteria1 == '') {
errors[i] = 'The  bonus interest (Criteria 1) is required.';
i++;
}
if (BonusInterestCriteria2 == '') {
errors[i] = 'The  bonus interest (Criteria 1) is required.';
i++;
}
if (BonusInterestCriteria3 == '') {
errors[i] = 'The bonus interest (Criteria 1) is required.';
i++;
}
if (FirstCapAmount == '') {
errors[i] = 'The  first cap amount is required.';
i++;
}
if (RemainingBonusInterest == '') {
errors[i] = 'The  bonus interest (Remaining) is required.';
i++;
}
if (parseInt(minPlacement) > parseInt(FirstCapAmount)) {
errors[i] = 'The  first cap amount  is not greater than minimum placement.';
i++;
}
}
if (formula == 10) {
var allInOneAccountF4 = $('#allInOneAccountF4');
var SalaryMinAmount = allInOneAccountF4.find('input[name="minimum_salary_aioa4"]').map(function () {
return $.trim($(this).val());
}).get();
var SpendMinAmount = allInOneAccountF4.find('input[name="minimum_spend_aioa4"]').map(function () {
return $.trim($(this).val());
}).get();
var HomeMinAmount = allInOneAccountF4.find('input[name="minimum_home_loan_aioa4"]').map(function () {
return $.trim($(this).val());
}).get();
var InsuranceMinAmount = allInOneAccountF4.find('input[name="minimum_insurance_aioa4"]').map(function () {
return $.trim($(this).val());
}).get();
var InvestmentMinAmount = allInOneAccountF4.find('input[name="minimum_investment_aioa4"]').map(function () {
return $.trim($(this).val());
}).get();
var boardRate = allInOneAccountF4.find('input[name="board_rate_aioa4"]').map(function () {
return $.trim($(this).val());
}).get();
var firstCapAmount = allInOneAccountF4.find('input[name="first_cap_amount_aioa4"]').map(function () {
return $.trim($(this).val());
}).get();
var minPlacements = allInOneAccountF4.find('input[name^="min_placement_aioa4"]').map(function () {
return $.trim($(this).val());
}).get();
var maxPlacements = allInOneAccountF4.find('input[name^="max_placement_aioa4"]').map(function () {
return $.trim($(this).val());
}).get();
var bonusInterestA = allInOneAccountF4.find('input[name^="bonus_interest_criteria_a_aioa4"]').map(function () {
return $.trim($(this).val());
}).get();
var bonusInterestB = allInOneAccountF4.find('input[name^="bonus_interest_criteria_b_aioa4"]').map(function () {
return $.trim($(this).val());
}).get();
var rangeError = false;
if (SpendMinAmount == '') {
errors[i] = 'The minimum requirement amount (Spend) is required.';
i++;
}
if (GiroMinAmount == '') {
errors[i] = 'The minimum requirement amount (Giro) is required.';
i++;
}
if (SalaryMinAmount == '') {
errors[i] = 'The minimum requirement amount (Salary) is required.';
i++;
}
if (HomeMinAmount == '') {
errors[i] = 'The minimum requirement amount (Home Loan) is required.';
i++;
}
if (InsuranceMinAmount == '') {
errors[i] = 'The minimum requirement amount (Insurance) is required.';
i++;
}
if (InvestmentMinAmount == '') {
errors[i] = 'The minimum requirement amount (Investment) is required.';
i++;
}
if (boardRate == '') {
errors[i] = 'The board rate is required.';
i++;
}
if (firstCapAmount == '') {
errors[i] = 'The first cap amount is required.';
i++;
}
$.each(minPlacements, function (k, v) {
if (minPlacements[k] == '' || maxPlacements[k] == '') {
errors[i] = 'The placement range is required.';
i++;
rangeError = true;
return false;
}
});
$.each(bonusInterestA, function (k, v) {
if (bonusInterestA[k] == '') {
errors[i] = 'The bonus interest (A) is required.';
i++;
return false;
}
});
$.each(bonusInterestB, function (k, v) {
if (bonusInterestB[k] == '') {
errors[i] = 'The bonus interest (B) is required.';
i++;
return false;
}
});
if (rangeError == false) {
$.ajax({
method: "POST",
url: "{{url('/admin/check-range')}}",
data: {max_placement: maxPlacements, min_placement: minPlacements},
cache: false,
async: false,
success: function (data) {
if (data == 1) {
errors[i] = 'Please check your placement range ';
i++;
}
if (data == 2) {
errors[i] = 'Max Placement must be greater than Min Placement';
i++;
}
}
});
}
$.each(minPlacements, function (k, v) {
if (Number(v) > Number(minPlacementAmount)) {
errors[i] = 'All placement must be less than or equal to maximum placement amount.';
i++;
return false;
}
if (Number(maxPlacements[k]) > Number(minPlacementAmount)) {
errors[i] = 'All placement must be less than or equal to maximum placement amount.';
i++;
return false;
}
});
}
if (formula == 23) {
var allInOneAccountF5 = $('#allInOneAccountF5');
var minPlacement = allInOneAccountF5.find('input[name="min_placement_aioa5"]').map(function () {
return $.trim($(this).val());
}).get();
var maxPlacement = allInOneAccountF5.find('input[name="max_placement_aioa5"]').map(function () {
return $.trim($(this).val());
}).get();
var SpendMinAmount1 = allInOneAccountF5.find('input[name="minimum_spend_1_aioa5"]').map(function () {
return $.trim($(this).val());
}).get();
var SpendBonusInterest1 = allInOneAccountF5.find('input[name="bonus_interest_spend_1_aioa5"]').map(function () {
return $.trim($(this).val());
}).get();
var SpendMinAmount2 = allInOneAccountF5.find('input[name="minimum_spend_2_aioa5"]').map(function () {
return $.trim($(this).val());
}).get();
var SpendBonusInterest2 = allInOneAccountF5.find('input[name="bonus_interest_spend_2_aioa5"]').map(function () {
return $.trim($(this).val());
}).get();
var SalaryMinAmount = allInOneAccountF5.find('input[name="minimum_salary_aioa5"]').map(function () {
return $.trim($(this).val());
}).get();
var SalaryBonusInterest = allInOneAccountF5.find('input[name="bonus_interest_salary_aioa5"]').map(function () {
return $.trim($(this).val());
}).get();
var GiroMinAmount = allInOneAccountF5.find('input[name="minimum_giro_payment_aioa5"]').map(function () {
return $.trim($(this).val());
}).get();
var GiroBonusInterest = allInOneAccountF5.find('input[name="bonus_interest_giro_payment_aioa5"]').map(function () {
return $.trim($(this).val());
}).get();
var PrivilegeMinAmount = allInOneAccountF5.find('input[name="minimum_privilege_pa_aioa5"]').map(function () {
return $.trim($(this).val());
}).get();
var PrivilegeBonusInterest = allInOneAccountF5.find('input[name="bonus_interest_privilege_aioa5"]').map(function () {
return $.trim($(this).val());
}).get();
var LoanMinAmount = allInOneAccountF5.find('input[name="minimum_loan_pa_aioa5"]').map(function () {
return $.trim($(this).val());
}).get();
var LoanBonusInterest = allInOneAccountF5.find('input[name="bonus_interest_loan_aioa5"]').map(function () {
return $.trim($(this).val());
}).get();
var FirstCapAmount = allInOneAccountF5.find('input[name="first_cap_amount_aioa5"]').map(function () {
return $.trim($(this).val());
}).get();
var RemainingBonusInterest = allInOneAccountF5.find('input[name="bonus_interest_remaining_amount_aioa5"]').map(function () {
return $.trim($(this).val());
}).get();
var interestName1 = allInOneAccountF5.find('input[name="other_interest_name_aioa5"]').map(function () {
return $.trim($(this).val());
}).get();
var minimumAmount1 = allInOneAccountF5.find('input[name="other_minimum_amount_aioa5"]').map(function () {
return $.trim($(this).val());
}).get();
var interest1 = allInOneAccountF5.find('input[name="other_interest_aioa5"]').map(function () {
return $.trim($(this).val());
}).get();
var status1 = allInOneAccountF5.find('input[name="status_other_aioa5"]').map(function () {
return $.trim($(this).val());
}).get();
if (Number(minPlacement) > Number(minPlacementAmount) || Number(maxPlacement) > Number(minPlacementAmount)) {
errors[i] = 'All placement must be less than or equal maximum placement amount.';
i++;
}
if (minPlacement == '' || maxPlacement == '' || ( parseInt(minPlacement) > parseInt(maxPlacement))) {
errors[i] = 'Please check your placement range. ';
i++;
}
if (SpendMinAmount1 != '') {
if (SpendBonusInterest1 == '') {
errors[i] = 'The  bonus interest (Spend 1) is required.';
i++;
}
}
if (SpendMinAmount2 != '') {
if (SpendBonusInterest2 == '') {
errors[i] = 'The  bonus interest (Spend 2) is required.';
i++;
}
}
if (SpendMinAmount1 != '' && SpendMinAmount2 != '') {
if (SpendMinAmount1 == SpendMinAmount2) {
errors[i] = 'You cannot input same amount for spend 1 and spend 2.';
i++;
}
if (SpendMinAmount1 > SpendMinAmount2) {
errors[i] = 'spend 2 amount must be grater than spend 1.';
i++;
}
}
if (SalaryMinAmount != '') {
if (SalaryBonusInterest == '') {
errors[i] = 'The  bonus interest (Salary) is required.';
i++;
}
}
if (GiroMinAmount != '') {
if (GiroBonusInterest == '') {
errors[i] = 'The  bonus interest (Giro) is required.';
i++;
}
}
if (PrivilegeMinAmount != '') {
if (PrivilegeBonusInterest == '') {
errors[i] = 'The  bonus interest (Privilege) is required.';
i++;
}
}
if (LoanMinAmount != '') {
if (LoanBonusInterest == '') {
errors[i] = 'The  bonus interest (Loan) is required.';
i++;
}
}
if (status1 == '1' && minimumAmount1 != '') {
if (interestName1 == '') {
errors[i] = 'The interest name is required.';
i++;
}
if (interest1 == '') {
errors[i] = 'The other interest is required.';
i++;
}
}
if (FirstCapAmount == '') {
errors[i] = 'The  first cap amount is required.';
i++;
}
if (RemainingBonusInterest == '') {
errors[i] = 'The  bonus interest (Remaining) is required.';
i++;
}
if (parseInt(minPlacement) > parseInt(FirstCapAmount)) {
errors[i] = 'The  first cap amount  is not greater than minimum placement.';
i++;
}
}
if ((jQuery.inArray(formula, LOAN) !== -1) || (productType == '<?php echo LOAN ;?>')) {
var rateType = $('#loanF1').find('select[name="rate_type_f1"]').map(function () {
return $.trim($(this).val());
}).get();
var propertyType = $('#loanF1').find('select[name="property_type_f1"]').map(function () {
return $.trim($(this).val());
}).get();
var completionStatus = $('#loanF1').find('select[name="completion_status_f1"]').map(function () {
return $.trim($(this).val());
}).get();
var thereAfterBonus = $('#loanF1').find('input[name="there_after_bonus_interest"]').map(function () {
return $.trim($(this).val());
}).get();
var thereAfterOther = $('#loanF1').find('input[name="there_after_rate_interest_other"]').map(function () {
return $.trim($(this).val());
}).get();
var tenures = $('#loanF1').find('select[name^="tenure_f1"]').map(function () {
return $.trim($(this).val());
}).get();
var bonusInterests = $('#loanF1').find('input[name^="bonus_interest_f1"]').map(function () {
return $.trim($(this).val());
}).get();
var otherInterest = $('#loanF1').find('input[name^="rate_interest_other_f1"]').map(function () {
return $.trim($(this).val());
}).get();
if (rateType == '') {
errors[i] = 'The  rate type is required.';
i++;
}
if (propertyType == '') {
errors[i] = 'The  property type is required.';
i++;
}
if (completionStatus == '') {
errors[i] = 'The  completion status is required.';
i++;
}
$.each(tenures, function (k, v) {
if (tenures[k] == '') {
errors[i] = 'The year is required.';
i++;
return false;
}
});
$.each(tenures, function (k, v) {
if (bonusInterests[k] == '' && otherInterest[k] == '') {
errors[i] = 'Minimum one interest is required.';
i++;
return false;
}
});
if (thereAfterBonus == '' && thereAfterOther == '') {
errors[i] = 'Minimum one there after interest is required.';
i++;
}
}
}
if (errors.length) {
$("#error-div").removeClass('display-none');
$.each(errors, function (k, v) {
errorSection.innerHTML = errorSection.innerHTML + '<p>' + v + '</p>';
});
return false;
}
}