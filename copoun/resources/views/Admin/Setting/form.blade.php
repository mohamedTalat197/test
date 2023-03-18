<div class="modal fade bd-example-modal-lg" id="formModel" tabindex="-1" role="dialog"
     aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formSubmit">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="titleOfModel"><i class="ti-marker-alt m-r-10"></i> Add new </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        @if($type ==4)
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-email">صورة المطورين</label>
                                    <input type="file" id="imageD" name="imageD" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-email">البريدالالكتروني</label>
                                    <input type="text" id="emailD" name="emailD" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-email">رقم الهاتف</label>
                                    <input type="text" id="phoneD" name="phoneD" class="form-control">
                                </div>
                            </div>
                        @endif
                        @if($type ==2)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-email">صورة عن الشركة</label>
                                    <input type="file" id="aboutImage" name="aboutImage" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-email">لوجو الشركة</label>
                                    <input type="file" id="companyLogo" name="companyLogo" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-email">رقم الهاتف</label>
                                    <input type="text" id="phone" name="phone" class="form-control">
                                </div>
                            </div>
                        @endif
                        @if($type==1)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-email">التلجرام</label>
                                    <input type="text" id="telgram" name="telgram" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-email">الواتساب</label>
                                    <input type="text" id="whatsApp" name="whatsApp" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-email">فايسبوك</label>
                                    <input type="text" id="facebook" name="facebook" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-email">تويتر</label>
                                    <input type="text" id="twitter" name="twitter" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-email">سناب شات</label>
                                    <input type="text" id="snap" name="snap" class="form-control">
                                </div>
                            </div>
                        @endif

                        @if($type==15)
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-email"> من نحن بالعربيه </label>
                                        <textarea id="about_ar" name="about_ar" class="form-control"></textarea>

                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-email"> من نحن بالانجليزيه </label>
                                        <textarea id="about_en" name="about_en" class="form-control"></textarea>
                                    </div>
                                </div>
                        @endif
                        @if($type==3)
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="example-email"> سياسة الخصوصية بالعربيه </label>
                                    <textarea id="terms_ar" name="terms_ar" class="form-control"></textarea>

                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="example-email"> سياسة الخصوصية بالانجليزيه </label>
                                    <textarea id="terms_en" name="terms_en" class="form-control"></textarea>
                                </div>
                            </div>
                    </div>
                    @endif
                </div>
                <div id="err"></div>
                <input type="hidden" name="id" id="id">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                    <button type="submit" id="save" class="btn btn-success"><i class="ti-save"></i> حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>
