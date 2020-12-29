  
                                        <!--begin::Wizard Step 4-->
                                        <div class="my-5 step" data-wizard-type="step-content">
                                            <h5 class="mb-10 font-weight-bold text-dark">Review Details and Submit</h5>

                                            <!--begin::Item-->
                                            <div class="border-bottom mb-5 pb-5">
                                                <div class="font-weight-bolder mb-3">Employee's personal details:</div>
                                                <div class="line-height-xl"><span x-text="formData.firstName"></span> <span x-text="formData.lastName"></span>
                                                <br />Phone: <span x-text="formData.phone"></span>
                                                <br />Address: <span x-text="formData.address"></span>
                                                <br />Civil Status: <span x-text="formData.civil"></span>
                                                <br />Sex: <span x-text="formData.sex"></span>
                                                </div>
                                            </div>
                                            <!--end::Item-->
                                            <!--begin::Item-->
                                            <div class="border-bottom mb-5 pb-5">
                                                <div class="font-weight-bolder mb-3">Employment Details:</div>
                                                <div class="line-height-xl">
                                                    Office: <span id="select2OfficeSpan"></span> <br>
                                                    Position: <span id="select2PositionSpan"></span> <br>
                                                    Status of Appointment: <span x-text="formData.appointment"></span> <br>
                                                    ID Card: <span x-text="formData.card"></span> <br>
                                                    Liaison: <span x-text="formData.liaison"></span>
                                                </div>
                                            </div>
                                            <!--end::Item-->
                                            <!--begin::Item-->
                                            <div>
                                                <div class="font-weight-bolder">Account Details:</div>
                                                <div class="line-height-xl">
                                                    Username: <span x-text="formData.username"></span>
                                                   
                                                </div>
                                            </div>
                                            <!--end::Item-->
                                        </div>
                                        <!--end::Wizard Step 4-->