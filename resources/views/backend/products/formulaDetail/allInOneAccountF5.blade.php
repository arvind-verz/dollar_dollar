<div class="display-none" id="allInOneAccountF5">
    @if(isset($product) && (in_array($product->formula_id,[ALL_IN_ONE_ACCOUNT_F5])))
        @if(count($product->product_range))
            <?php //dd(old('min_placement')[0]); ?>
            @foreach($product->product_range as $key => $value)

                <div id="all_in_one_account_f5_{{$key}}">
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
                                       name="min_placement_aioa5"
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
                                       name="max_placement_aioa5"
                                       value="{{ $value->max_range }}">

                            </div>

                        </div>
                        <div class="col-sm-2" id="add-aioa-placement-range-f5-button">

                        </div>

                    </div>
                    <div class="form-group ">
                        <label for="title" class="col-sm-2 control-label"></label>

                        <div class="col-sm-8 ">
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="">Minimum Requirement Amount (Spend 1)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="minimum_spend_1_aioa5" value="{{ $value->minimum_spend_1  }}"
                                           placeholder="">

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Bonus Interest (Spend 1)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="bonus_interest_spend_1_aioa5"
                                           value="{{ $value->bonus_interest_spend_1  }}"
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
                                    <label for="">Minimum Requirement Amount (Spend 2)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="minimum_spend_2_aioa5" value="{{ $value->minimum_spend_2  }}"
                                           placeholder="">

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Bonus Interest (Spend 2)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="bonus_interest_spend_2_aioa5"
                                           value="{{ $value->bonus_interest_spend_2  }}"
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
                                    <label for="">Minimum Requirement Amount (Salary 1)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="minimum_salary_aioa5" value="{{ $value->minimum_salary  }}"
                                           placeholder="">

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Bonus Interest (Salary 1)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="bonus_interest_salary_aioa5"
                                           value="{{ $value->bonus_interest_salary  }}"
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
                                    <label for="">Minimum Requirement Amount (Salary 2)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="minimum_salary_aioa5_2" value="{{ isset($value->minimum_salary_2)?$value->minimum_salary_2:null  }}"
                                           placeholder="">

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Bonus Interest (Salary 2)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="bonus_interest_salary_aioa5_2"
                                           value="{{ isset($value->bonus_interest_salary_2)?$value->bonus_interest_salary_2:null  }}"
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
                                           name="minimum_giro_payment_aioa5" value="{{ $value->minimum_giro_payment  }}"
                                           placeholder="">

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Bonus Interest (Giro)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="bonus_interest_giro_payment_aioa5"
                                           value="{{ $value->bonus_interest_giro_payment  }}"
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
                                    <label for="">Minimum Requirement Amount (Privilege)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="minimum_privilege_pa_aioa5" value="{{ $value->minimum_privilege_pa  }}"
                                           placeholder="">

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Bonus Interest (Privilege)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="bonus_interest_privilege_aioa5"
                                           value="{{ $value->bonus_interest_privilege  }}"
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
                                           name="minimum_loan_pa_aioa5" value="{{ $value->minimum_loan_pa  }}"
                                           placeholder="">

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Bonus Interest (Loan)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="bonus_interest_loan_aioa5" value="{{ $value->bonus_interest_loan  }}"
                                           placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">&emsp;</div>
                    </div>
                    <div class="form-group " id="aio-5-1">
                        <label for="title" class="col-sm-2 control-label"></label>

                        <div class="col-sm-8 ">
                            <div class="form-row">
                                <div class="col-md-3 mb-3">
                                    <label for="">Other Criteria 1</label>
                                    <input type="text" class="form-control " id=""
                                           name="other_interest1_name_aioa5"
                                           value="{{ $value->other_interest1_name  }}"
                                           placeholder="">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Minimum Requirement Amount </label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="other_minimum_amount1_aioa5"
                                           value="{{ $value->other_minimum_amount1  }}"
                                           placeholder="">

                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="">Interest</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="other_interest1_aioa5"
                                           value="{{ $value->other_interest1  }}"
                                           placeholder="">
                                </div>
                                <div class="col-md-3 mb-3">
                                    @if($value->status_other1==1)
                                            <input type="hidden" id="aioa-5-1-status-input" name="status_other1_aioa5"
                                                   value="1"/>
                                            <label for="">Status</label>
                                            <button type="button" data-status="true" id="aioa-5-1-status"
                                                    class="btn btn-block btn-success btn-social"
                                                    onclick="changeAIO5Status(this)"><i class="fa fa-check"></i> Enable
                                            </button>

                                    @else
                                            <input type="hidden" id="aioa-5-1-status-input" name="status_other1_aioa5"
                                                   value="0"/>
                                            <label for="">Status</label>
                                            <button type="button" data-status="false" id="aioa-5-1-status"
                                                    class="btn btn-block btn-danger btn-social"
                                                    onclick="changeAIO5Status(this)"><i class="fa fa-times"></i> Disable
                                            </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">&emsp;</div>
                    </div>
                    <div class="form-group " id="aio-5-1">
                        <label for="title" class="col-sm-2 control-label"></label>

                        <div class="col-sm-8 ">
                            <div class="form-row">
                                <div class="col-md-3 mb-3">
                                    <label for="">Other Criteria 2</label>
                                    <input type="text" class="form-control " id=""
                                           name="other_interest2_name_aioa5"
                                           value="{{ $value->other_interest2_name  }}"
                                           placeholder="">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Minimum Requirement Amount </label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="other_minimum_amount2_aioa5"
                                           value="{{ $value->other_minimum_amount2  }}"
                                           placeholder="">

                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="">Interest</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="other_interest2_aioa5"
                                           value="{{ $value->other_interest2  }}"
                                           placeholder="">
                                </div>
                                <div class="col-md-3 mb-3">
                                    @if($value->status_other2==1)
                                        <input type="hidden" id="aioa-5-2-status-input" name="status_other2_aioa5"
                                               value="1"/>
                                        <label for="">Status</label>
                                        <button type="button" data-status="true" id="aioa-5-2-status"
                                                class="btn btn-block btn-success btn-social"
                                                onclick="changeAIO5Status(this)"><i class="fa fa-check"></i> Enable
                                        </button>

                                    @else
                                        <input type="hidden" id="aioa-5-2-status-input" name="status_other2_aioa5"
                                               value="0"/>
                                        <label for="">Status</label>
                                        <button type="button" data-status="false" id="aioa-5-2-status"
                                                class="btn btn-block btn-danger btn-social"
                                                onclick="changeAIO5Status(this)"><i class="fa fa-times"></i> Disable
                                        </button>
                                    @endif
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
                                           name="first_cap_amount_aioa5" value="{{ $value->first_cap_amount  }}"
                                           placeholder="">

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Bonus Interest (Remaining)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="bonus_interest_remaining_amount_aioa5"
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

        <div id="all_in_one_account_f5_0">
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
                               name="min_placement_aioa5"
                               value="{{ old('min_placement_aioa5') ? old('min_placement_aioa5') :''  }}">

                    </div>
                </div>

                <div class="col-sm-4 ">

                    <div class="input-group date ">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-danger">Max Placement
                            </button>
                        </div>
                        <input type="text" class="form-control pull-right only_numeric"
                               name="max_placement_aioa5"
                               value="{{ old('max_placement_aioa5') ? old('max_placement_aioa5') :''  }}">

                    </div>

                </div>
                <div class="col-sm-2" id="add-aioa-placement-range-f5-button">

                </div>

            </div>
            <div class="form-group ">
                <label for="title" class="col-sm-2 control-label"></label>

                <div class="col-sm-8 ">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="">Minimum Requirement Amount (Spend 1)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="minimum_spend_1_aioa5"
                                   placeholder="">

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Bonus Interest (Spend 1)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="bonus_interest_spend_1_aioa5"
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
                            <label for="">Minimum Requirement Amount (Spend 2)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="minimum_spend_2_aioa5"
                                   placeholder="">

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Bonus Interest (Spend 2)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="bonus_interest_spend_2_aioa5"
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
                            <label for="">Minimum Requirement Amount (Salary 1)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="minimum_salary_aioa5"
                                   placeholder="">

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Bonus Interest (Salary 1)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="bonus_interest_salary_aioa5"
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
                            <label for="">Minimum Requirement Amount (Salary 2)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="minimum_salary_aioa5_2"
                                   placeholder="">

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Bonus Interest (Salary 2)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="bonus_interest_salary_aioa5_2"
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
                            <label for="">Minimum Requirement Amount (Privilege)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="minimum_privilege_pa_aioa5"
                                   placeholder="">

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Bonus Interest (Privilege)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="bonus_interest_privilege_aioa5"
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
                                   name="minimum_giro_payment_aioa5"
                                   placeholder="">

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Bonus Interest (Giro)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="bonus_interest_giro_payment_aioa5"
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
                                   name="minimum_loan_pa_aioa5"
                                   placeholder="">

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Bonus Interest (Loan)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="bonus_interest_loan_aioa5"
                                   placeholder="">
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">&emsp;</div>
            </div>
            <div class="form-group " id="aio-5-1">
                <label for="title" class="col-sm-2 control-label"></label>

                <div class="col-sm-8 ">
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label for=""> Other Criteria 1</label>
                            <input type="text" class="form-control " id=""
                                   name="other_interest1_name_aioa5"
                                   placeholder="">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="">Minimum Requirement Amount </label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="other_minimum_amount1_aioa5"
                                   placeholder="">

                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="">Interest</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="other_interest1_aioa5"
                                   placeholder="">
                        </div>
                        <div class="col-md-3 mb-3">
                            <input type="hidden" id="aioa-5-1-status-input" name="status_other1_aioa5" value="1"/>
                            <label for="">Status</label>
                            <button type="button" data-status="true" id="aioa-5-1-status"
                                    class="btn btn-block btn-success btn-social"
                                    onclick="changeAIO5Status(this)"><i class="fa fa-check"></i> Enable
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">&emsp;</div>
            </div>
            <div class="form-group " id="aio-5-1">
                <label for="title" class="col-sm-2 control-label"></label>

                <div class="col-sm-8 ">
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label for=""> Other Criteria 2</label>
                            <input type="text" class="form-control " id=""
                                   name="other_interest2_name_aioa5"
                                   placeholder="">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="">Minimum Requirement Amount </label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="other_minimum_amount2_aioa5"
                                   placeholder="">

                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="">Interest</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="other_interest2_aioa5"
                                   placeholder="">
                        </div>
                        <div class="col-md-3 mb-3">
                            <input type="hidden" id="aioa-5-2-status-input" name="status_other2_aioa5" value="1"/>
                            <label for="">Status</label>
                            <button type="button" data-status="true" id="aioa-5-2-status"
                                    class="btn btn-block btn-success btn-social"
                                    onclick="changeAIO5Status(this)"><i class="fa fa-check"></i> Enable
                            </button>
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
                                   name="first_cap_amount_aioa5"
                                   placeholder="">

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Bonus Interest (Remaining)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="bonus_interest_remaining_amount_aioa5"
                                   placeholder="">
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">&emsp;</div>
            </div>

        </div>
    @endif
    <div id="aioa-placement-range-f5"></div>
</div>