<div class="display-none" id="allInOneAccountF3">
    @if(isset($product) && (in_array($product->formula_id,[ALL_IN_ONE_ACCOUNT_F3])))
        @if(count($product->product_range))
            <?php //dd(old('min_placement')[0]); ?>
            @foreach($product->product_range as $key => $value)

                <div id="all_in_one_account_f1_{{$key}}">
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">Formula Detail</label>

                        <div class="col-sm-4">
                            <div class="input-group date">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-success">Min
                                        Placement
                                    </button>
                                </div>
                                <input type="text" class="form-control pull-right only_numeric "
                                       name="min_placement_aioa3"
                                       value="{{ $value-> min_range }}">

                            </div>
                        </div>

                        <div class="col-sm-4 ">

                            <div class="input-group date ">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-danger">Max Placement
                                    </button>
                                </div>
                                <input type="text" class="form-control pull-right only_numeric"
                                       name="max_placement_aioa3"
                                       value="{{ $value->max_range }}">

                            </div>

                        </div>
                        <div class="col-sm-2" id="add-aioa-placement-range-f3-button">

                        </div>

                    </div>
                    <div class="form-group ">
                        <label for="title" class="col-sm-2 control-label"></label>

                        <div class="col-sm-8 ">
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="">Minimum Amount (Salary)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="minimum_salary_aioa3" value="{{ $value->minimum_salary  }}"
                                           placeholder="">

                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Minimum No Payment (Giro)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="minimum_giro_payment_aioa3" value="{{ $value->minimum_giro_payment  }}"
                                           placeholder="">

                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Minimum Amount (Spend)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="minimum_spend_aioa3" value="{{ $value->minimum_spend  }}"
                                           placeholder="">

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">&emsp;</div>
                    </div>
                    <div class="form-group ">
                        <label for="title" class="col-sm-2 control-label"></label>

                        <div class="col-sm-8 ">
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="">Minimum Amount (Hire Purchase Loan)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="minimum_hire_purchase_loan_aioa3"
                                           value="{{ $value->minimum_hire_purchase_loan  }}"
                                           placeholder="">

                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Minimum Amount (Renovation Loan)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="minimum_renovation_loan_aioa3"
                                           value="{{ $value->minimum_renovation_loan  }}"
                                           placeholder="">

                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Minimum Amount (Home Loan)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="minimum_home_loan_aioa3" value="{{ $value->minimum_home_loan  }}"
                                           placeholder="">

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">&emsp;</div>
                    </div>
                    <div class="form-group ">
                        <label for="title" class="col-sm-2 control-label"></label>

                        <div class="col-sm-8">
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="">Minimum Amount (Edu Loan)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="minimum_education_loan_aioa3"
                                           value="{{ $value->minimum_education_loan  }}"
                                           placeholder="">

                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Minimum Amount (Insurance)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="minimum_insurance_aioa3" value="{{ $value->minimum_insurance  }}"
                                           placeholder="">

                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Minimum Amount (Unit Trust)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="minimum_unit_trust_aioa3" value="{{ $value->minimum_unit_trust  }}"
                                           placeholder="">

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">&emsp;</div>
                    </div>
                    <div class="form-group ">
                        <label for="title" class="col-sm-2 control-label"></label>

                        <div class="col-sm-8 ">
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="">No of Requirement (Criteria 1)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="requirement_criteria1_aioa3"
                                           value="{{ $value->requirement_criteria1  }}"
                                           placeholder="">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">No of Requirement (Criteria 2)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="requirement_criteria2_aioa3"
                                           value="{{ $value->requirement_criteria2  }}"
                                           placeholder="">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">No of Requirement (Criteria 3)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="requirement_criteria3_aioa3"
                                           value="{{ $value->requirement_criteria3  }}"
                                           placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">&emsp;</div>
                    </div>
                    <div class="form-group ">
                        <label for="title" class="col-sm-2 control-label"></label>

                        <div class="col-sm-8 ">
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="">Bonus Interest (Criteria 1)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="bonus_interest_criteria1_aioa3"
                                           value="{{ $value->bonus_interest_criteria1  }}"
                                           placeholder="">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Bonus Interest (Criteria 2)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="bonus_interest_criteria2_aioa3"
                                           value="{{ $value->bonus_interest_criteria2  }}"
                                           placeholder="">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Bonus Interest (Criteria 3)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="bonus_interest_criteria3_aioa3"
                                           value="{{ $value->bonus_interest_criteria3  }}"
                                           placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">&emsp;</div>
                    </div>
                    <div class="form-group ">
                        <label for="title" class="col-sm-2 control-label"></label>

                        <div class="col-sm-8 ">
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="">First Cap Amount</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="first_cap_amount_aioa3" value="{{ $value->first_cap_amount  }}"
                                           placeholder="">

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Bonus Interest (Remaining)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="bonus_interest_remaining_amount_aioa3"
                                           value="{{ $value->bonus_interest_remaining_amount  }}"
                                           placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">&emsp;</div>
                    </div>
                </div>
            @endforeach
        @endif
    @else

        <div id="all_in_one_account_f3_0">
            <div class="form-group">
                <label for="title" class="col-sm-2 control-label">Formula Detail</label>

                <div class="col-sm-4">
                    <div class="input-group date">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-success">Min
                                Placement
                            </button>
                        </div>
                        <input type="text" class="form-control pull-right only_numeric "
                               name="min_placement_aioa3"
                               value="">

                    </div>
                </div>

                <div class="col-sm-4 ">

                    <div class="input-group date ">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-danger">Max Placement
                            </button>
                        </div>
                        <input type="text" class="form-control pull-right only_numeric"
                               name="max_placement_aioa3"
                               value="">

                    </div>

                </div>
                <div class="col-sm-2" id="add-aioa-placement-range-f3-button">

                </div>

            </div>
            <div class="form-group ">
                <label for="title" class="col-sm-2 control-label"></label>

                <div class="col-sm-8 ">
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="">Minimum Amount (Salary)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="minimum_salary_aioa3" value=""
                                   placeholder="">

                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="">Minimum No of Payment (Giro)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="minimum_giro_payment_aioa3" value=""
                                   placeholder="">

                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="">Minimum Amount (Spend)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="minimum_spend_aioa3" value=""
                                   placeholder="">

                        </div>
                    </div>
                </div>
                <div class="col-sm-2">&emsp;</div>
            </div>
            <div class="form-group ">
                <label for="title" class="col-sm-2 control-label"></label>

                <div class="col-sm-8 ">
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="">Minimum Amount (Hire Purchase Loan)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="minimum_hire_purchase_loan_aioa3"
                                   value=""
                                   placeholder="">

                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="">Minimum Amount (Renovation Loan)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="minimum_renovation_loan_aioa3" value=""
                                   placeholder="">

                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="">Minimum Amount (Home Loan)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="minimum_home_loan_aioa3" value=""
                                   placeholder="">

                        </div>
                    </div>
                </div>
                <div class="col-sm-2">&emsp;</div>
            </div>
            <div class="form-group ">
                <label for="title" class="col-sm-2 control-label"></label>

                <div class="col-sm-8 ">
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="">Minimum Amount (Edu Loan)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="minimum_education_loan_aioa3" value=""
                                   placeholder="">

                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="">Minimum Amount (Insurance)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="minimum_insurance_aioa3" value=""
                                   placeholder="">

                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="">Minimum Amount (Unit Trust)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="minimum_unit_trust_aioa3" value=""
                                   placeholder="">

                        </div>
                    </div>
                </div>
                <div class="col-sm-2">&emsp;</div>
            </div>
            <div class="form-group ">
                <label for="title" class="col-sm-2 control-label"></label>

                <div class="col-sm-8 ">
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="">No of Requirement (Criteria 1)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="requirement_criteria1_aioa3" value=""
                                   placeholder="">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="">No of Requirement (Criteria 2)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="requirement_criteria2_aioa3" value=""
                                   placeholder="">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="">No of Requirement (Criteria 3)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="requirement_criteria3_aioa3" value=""
                                   placeholder="">
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">&emsp;</div>
            </div>
            <div class="form-group ">
                <label for="title" class="col-sm-2 control-label"></label>

                <div class="col-sm-8 ">
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="">Bonus Interest (Criteria 1)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="bonus_interest_criteria1_aioa3" value=""
                                   placeholder="">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="">Bonus Interest (Criteria 2)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="bonus_interest_criteria2_aioa3" value=""
                                   placeholder="">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="">Bonus Interest (Criteria 3)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="bonus_interest_criteria3_aioa3" value=""
                                   placeholder="">
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">&emsp;</div>
            </div>
            <div class="form-group ">
                <label for="title" class="col-sm-2 control-label"></label>

                <div class="col-sm-8 ">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="">First Cap Amount</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="first_cap_amount_aioa3" value=""
                                   placeholder="">

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Bonus Interest (Remaining)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="bonus_interest_remaining_amount_aioa3"
                                   value=""
                                   placeholder="">
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">&emsp;</div>
            </div>
        </div>
    @endif
    <div id="aioa-placement-range-f3"></div>

</div>

