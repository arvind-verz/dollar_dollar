<div class="display-none" id="allInOneAccountF1">
    @if(isset($product) && (in_array($product->formula_id,[ALL_IN_ONE_ACCOUNT_F1])))
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
                                       name="min_placement_aioa1"
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
                                       name="max_placement_aioa1"
                                       value="{{ $value->max_range }}">

                            </div>

                        </div>
                        <div class="col-sm-2" id="add-aioa-placement-range-f1-button">

                        </div>

                    </div>
                    <div class="form-group ">
                        <label for="title" class="col-sm-2 control-label"></label>

                        <div class="col-sm-8 ">
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="">Minimum Requirement Amount (Salary)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="minimum_salary_aioa1" value="{{ $value->minimum_salary  }}"
                                           placeholder="">

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Bonus Interest (Salary)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="bonus_interest_salary_aioa1" value="{{ $value->bonus_interest_salary  }}"
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
                                    <label for="">Minimum Requirement Number of Payment (Giro)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="minimum_giro_payment_aioa1"  value="{{ $value->minimum_giro_payment  }}"
                                           placeholder="">

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Bonus Interest (Giro)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="bonus_interest_giro_payment_aioa1"  value="{{ $value->bonus_interest_giro_payment  }}"
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
                                    <label for="">Minimum Requirement Amount (Spend)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="minimum_spend_aioa1"  value="{{ $value->minimum_spend  }}"
                                           placeholder="">

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Bonus Interest (Spend)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="bonus_interest_spend_aioa1"  value="{{ $value->bonus_interest_spend  }}"
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
                                    <label for="">Minimum Requirement Amount (Wealth)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="minimum_wealth_pa_aioa1"  value="{{ $value->minimum_wealth_pa  }}"
                                           placeholder="">

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Bonus Interest (Wealth)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="bonus_interest_wealth_aioa1"  value="{{ $value->bonus_interest_wealth  }}"
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
                                    <label for="">Minimum Requirement Amount (Loan)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="minimum_loan_pa_aioa1"  value="{{ $value->minimum_loan_pa  }}"
                                           placeholder="">

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Bonus Interest (Loan)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="bonus_interest_loan_aioa1"  value="{{ $value->bonus_interest_loan  }}"
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
                                    <label for="">Minimum Requirement Amount (Bonus)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="minimum_bonus_aioa1"  value="{{ $value->bonus_amount  }}"
                                           placeholder="">

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Bonus Interest (Bonus)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="bonus_interest_bonus_aioa1"  value="{{ $value->bonus_interest  }}"
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
                                           name="first_cap_amount_aioa1"  value="{{ $value->first_cap_amount  }}"
                                           placeholder="">

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Bonus Interest (Remaining)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="bonus_interest_remaining_amount_aioa1"  value="{{ $value->bonus_interest_remaining_amount  }}"
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

        <div id="all_in_one_account_f1_0">
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
                               name="min_placement_aioa1"
                               value="{{ old('min_placement_aioa1') ? old('min_placement_aioa1') :''  }}">

                    </div>
                </div>

                <div class="col-sm-4 ">

                    <div class="input-group date ">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-danger">Max Placement
                            </button>
                        </div>
                        <input type="text" class="form-control pull-right only_numeric"
                               name="max_placement_aioa1"
                               value="{{ old('max_placement_aioa1') ? old('max_placement_aioa1') :''  }}">

                    </div>

                </div>
                <div class="col-sm-2" id="add-aioa-placement-range-f1-button">

                </div>

            </div>
            <div class="form-group ">
                <label for="title" class="col-sm-2 control-label"></label>

                <div class="col-sm-8 ">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="">Minimum Requirement Amount (Salary)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="minimum_salary_aioa1"
                                   placeholder="">

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Bonus Interest (Salary)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="bonus_interest_salary_aioa1"
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
                            <label for="">Minimum Requirement Number of Payment (Giro)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="minimum_giro_payment_aioa1"
                                   placeholder="">

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Bonus Interest (Giro)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="bonus_interest_giro_payment_aioa1"
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
                            <label for="">Minimum Requirement Amount (Spend)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="minimum_spend_aioa1"
                                   placeholder="">

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Bonus Interest (Spend)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="bonus_interest_spend_aioa1"
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
                            <label for="">Minimum Requirement Amount (Wealth)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="minimum_wealth_pa_aioa1"
                                   placeholder="">

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Bonus Interest (Wealth)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="bonus_interest_wealth_aioa1"
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
                            <label for="">Minimum Requirement Amount (Loan)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="minimum_loan_pa_aioa1"
                                   placeholder="">

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Bonus Interest (Loan)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="bonus_interest_loan_aioa1"
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
                            <label for="">Minimum Requirement Amount (Bonus)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="minimum_bonus_aioa1"
                                   placeholder="">

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Bonus Interest (Bonus)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="bonus_interest_bonus_aioa1"
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
                                   name="first_cap_amount_aioa1"
                                   placeholder="">

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Bonus Interest (Remaining)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="bonus_interest_remaining_amount_aioa1"
                                   placeholder="">
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">&emsp;</div>
            </div>

        </div>
    @endif
    <div id="aioa-placement-range-f1"></div>

</div>

