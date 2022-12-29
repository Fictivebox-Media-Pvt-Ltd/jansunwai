<!DOCTYPE html>
<html lang="zxx" class="js">
<?php include_once 'head.php'; ?>

<style>
.card .table tr:first-child th,
.card .table tr:first-child td {
    white-space: nowrap;
}

.form-group {
    position: relative;
    margin-bottom: 1.25rem !important;
}
</style>

<body class="nk-body bg-lighter npc-default has-sidebar">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            <?php include_once 'sidebar.php'; ?>
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                <?php include_once 'header.php'; ?>
                <!-- main header @e -->
                <!-- content @s -->
                <div class="nk-content " style="margin-top: 50px;">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block nk-block-lg">
                                    <div class="nk-block-head">
                                        <div class="nk-block-head-content">
                                            <div class="row">
                                                <div class="col-md-6 ">
                                                    <nav aria-label="breadcrumb">
                                                        <ol class="breadcrumb">
                                                            <li class="breadcrumb-item"><a href="userbase.php">List of all
                                                                    voters</a></li>
                                                            <li class="breadcrumb-item active" aria-current="page">
                                                                Mahila voters List</li>
                                                        </ol>
                                                    </nav>
                                                    <h4 class="nk-block-title">Mahila voters List</h4>
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <button type="submit" name="submit"
                                                        class="btn btn-lg btn-warning justify-content-center" title=""
                                                        data-original-title="Export Excel
                                                        File">Export Excel File</button>
                                                    <button type="submit" name="submit"
                                                        class="btn btn-lg btn-info justify-content-center" title=""
                                                        data-original-title="Import Excel
                                                        File">Import Excel File</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card-preview w-100" style="width: max-content;">
                                        <div class="card-inner">
                                            <form method="POST" class="gy-3">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <select name="mandal" class="form-control" id="mandal_list">
                                                                <option value="" selected="" disabled="" hidden="">मंडल
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <select name="panchayat" class="form-control"
                                                                id="panchayat_list">
                                                                <option value="" selected="" disabled="" hidden="">
                                                                    पंचायत</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <select name="boothRange" class="form-control"
                                                                id="booth_range">
                                                                <option value="" selected="" disabled="" hidden="">बूथ
                                                                    रेंज</option>
                                                                <option
                                                                    value="160,161,162,163,164,165,166,167,168,169,170,171,172">
                                                                    160,161,162,163,164,165,166,167,168,169,170,171,172
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <select name="category" class="form-control" id="category">
                                                                <option value="" selected="" disabled="" hidden="">
                                                                    क्षेणी</option>

                                                                <option value=""></option>
                                                                <option value="एसटी">एसटी</option>
                                                                <option value="एससी">एससी</option>
                                                                <option value="ओबीसी">ओबीसी</option>
                                                                <option value="सामान्य">सामान्य</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <select name="caste" class="form-control" id="caste_list">
                                                                <option value="" selected="" disabled="" hidden="">जाति
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <select name="pesha" class="form-control" id="pesha_list">
                                                                <option value="" selected="" disabled="" hidden="">पेशा
                                                                </option>
                                                                <option value="किसान">किसान</option>
                                                                <option value="व्यवसाय">व्यवसाय</option>
                                                                <option value="पानी सप्लाई">पानी सप्लाई</option>
                                                                <option value="नौकरी">नौकरी</option>
                                                                <option value="मजदूर">मजदूर</option>
                                                                <option value="विद्यार्थी">विद्यार्थी</option>
                                                                <option value="बेरोजगार">बेरोजगार</option>
                                                                <option value="गृहणी">गृहणी</option>
                                                                <option value="रिटायर्ड">रिटायर्ड</option>
                                                                <option value="कोई कार्य नही कर रहे">कोई कार्य नही कर
                                                                    रहे</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <select name="pramukh_mudde" class="form-control">
                                                                <option value="" selected="" disabled="" hidden="">
                                                                    प्रमुख मुद्दे</option>
                                                                <option value="सड़क">सड़क</option>
                                                                <option value="बिजली">बिजली</option>
                                                                <option value="पानी सप्लाई">पानी सप्लाई</option>
                                                                <option value="रोज़गार">रोज़गार</option>
                                                                <option value="शिक्षा">शिक्षा</option>
                                                                <option value="स्वास्थ्य सुविधएँ">स्वास्थ्य सुविधएँ
                                                                </option>
                                                                <option value="जल निकासी">जल निकासी</option>
                                                                <option value="स्ट्रीट लाइट">स्ट्रीट लाइट</option>
                                                                <option value="कचरा प्रबंधन">कचरा प्रबंधन</option>
                                                                <option value="लोकल ट्रांसपोर्ट">लोकल ट्रांसपोर्ट
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <select name="mojuda_sarkaar" class="form-control">
                                                                <option value="" selected="" disabled="" hidden="">
                                                                    मौजूदा सरकार</option>
                                                                <option value="बढ़िया">बढ़िया</option>
                                                                <option value="संतोषजनक">संतोषजनक</option>
                                                                <option value="बुरा">बुरा</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <select name="2019_loksabha" class="form-control">
                                                                <option value="" selected="" disabled="" hidden="">2019
                                                                    लोकसभा</option>
                                                                <option value="कांग्रेस">कांग्रेस</option>
                                                                <option value="भारतीय जनता पार्टी">भारतीय जनता पार्टी
                                                                </option>
                                                                <option value="जनता सेना">जनता सेना</option>
                                                                <option value="राष्ट्रीय लोकतांत्रिक पार्टी">राष्ट्रीय
                                                                    लोकतांत्रिक पार्टी</option>
                                                                <option value="बहुजन समाज पार्टी">बहुजन समाज पार्टी
                                                                </option>
                                                                <option value="अन्य">अन्य</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <select name="2018_vidhansabha" class="form-control">
                                                                <option value="" selected="" disabled="" hidden="">2018
                                                                    विधानसभा</option>
                                                                <option value="कांग्रेस">कांग्रेस</option>
                                                                <option value="भारतीय जनता पार्टी">भारतीय जनता पार्टी
                                                                </option>
                                                                <option value="जनता सेना">जनता सेना</option>
                                                                <option value="राष्ट्रीय लोकतांत्रिक पार्टी">राष्ट्रीय
                                                                    लोकतांत्रिक पार्टी</option>
                                                                <option value="बहुजन समाज पार्टी">बहुजन समाज पार्टी
                                                                </option>
                                                                <option value="अन्य">अन्य</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <select name="partyVsCandidate" class="form-control">
                                                                <option value="" selected="" disabled="" hidden="">
                                                                    पार्टी / सदस्य</option>
                                                                <option value="पार्टी">पार्टी</option>
                                                                <option value="उम्मीदवार">उम्मीदवार</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <select name="vichardhara" class="form-control">
                                                                <option value="" selected="" disabled="" hidden="">
                                                                    विचारधारा</option>
                                                                <option value="राम मंदिर">राम मंदिर</option>
                                                                <option value="किसान आंदोलन">किसान आंदोलन</option>
                                                                <option value="धारा 370">धारा 370 (कश्मीर)</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <select name="corona" class="form-control">
                                                                <option value="" selected="" disabled="" hidden="">
                                                                    कोरोना</option>
                                                                <option value="अशोक गहलोत सरकार">अशोक गहलोत सरकार
                                                                </option>
                                                                <option value="मोदी सरकार">मोदी सरकार</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <select name="local_candidate" class="form-control">
                                                                <option value="" selected="" disabled="" hidden="">लोकल
                                                                    कार्यकर्ता</option>
                                                                <option value="कांग्रेस">कांग्रेस</option>
                                                                <option value="भारतीय जनता पार्टी">भारतीय जनता पार्टी
                                                                </option>
                                                                <option value="जनता सेना">जनता सेना</option>
                                                                <option value="राष्ट्रीय लोकतांत्रिक पार्टी">राष्ट्रीय
                                                                    लोकतांत्रिक पार्टी</option>
                                                                <option value="बहुजन समाज पार्टी">बहुजन समाज पार्टी
                                                                </option>
                                                                <option value="अन्य">अन्य</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <select name="2023_vidhansabha" class="form-control">
                                                                <option value="" selected="" disabled="" hidden="">2023
                                                                    विधानसभा</option>
                                                                <option value="कांग्रेस">कांग्रेस</option>
                                                                <option value="भारतीय जनता पार्टी">भारतीय जनता पार्टी
                                                                </option>
                                                                <option value="जनता सेना">जनता सेना</option>
                                                                <option value="राष्ट्रीय लोकतांत्रिक पार्टी">राष्ट्रीय
                                                                    लोकतांत्रिक पार्टी</option>
                                                                <option value="बहुजन समाज पार्टी">बहुजन समाज पार्टी
                                                                </option>
                                                                <option value="अन्य">अन्य</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <select name="ageGroup" class="form-control">
                                                                <option value="" selected="" disabled="" hidden="">Age
                                                                    Group</option>
                                                                <option value="25~30">25 ~ 30</option>
                                                                <option value="31~35">31 ~ 35</option>
                                                                <option value="36~40">36 ~ 40</option>
                                                                <option value="40~45">40 ~ 45</option>
                                                                <option value="45~50">45 ~ 50</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button name="import" type="submit"
                                                            class="btn btn-lg btn-primary w-100 justify-content-center">Appy</button>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button name="import" type="submit"
                                                            class="btn btn-lg btn-danger w-100 justify-content-center">Reset</button>
                                                    </div>
                                                    <div class="col-md-12 text-right mt-3">
                                                        <button name="import" type="submit"
                                                            class="btn btn-lg btn-light justify-content-center py-1 px-3 btn-tooltip"
                                                            data-original-title="Click to send an Whatsapp SMS"
                                                            title=""><em class="icon ni ni-emails"></em>&nbsp;Send
                                                            SMS</button>
                                                        <select name="sms" class="btn btn-lg btn-light py-1 px-3"
                                                            data-original-title="" title="">
                                                            <option>--Send SMS--</option>
                                                            <option
                                                                value="कोरोना आपदा की इस घड़ी में मैं ईश्वर से प्रार्थना करता हूँ कि हम सभी को सुख शांति एवं उत्तम स्वास्थ्य का आशीर्वाद दें। आप सभी घरों में रहें व स्वस्थ रहें और मेरे योग्य किसी भी प्रकार की सहायता के लिए संपर्क करें। हिम्मत सिंह झाला एसआरएम ग्रुप 9414197766 8003394949">
                                                                Corona</option>
                                                            <option
                                                                value="आप सभी को शक्ति उपासना के महापर्व नवरात्रि की हार्दिक शुभकामनाएं। हिम्मत सिंह झाला भाजपा प्रत्याशी, वल्लभनगर विधानसभा।">
                                                                Navrati Puja</option>
                                                            <option
                                                                value="भारतीय जनता पार्टी के शीर्ष नेतृत्व, वरिष्ठ पदाधिकारीगण एवं सभी कार्यकर्ताओं का मुझ पर विश्वास जताने के लिए एवं अवसर देने के लिए आप सब का आभार व्यक्त करता हूँ। मैं आपको विश्वास दिलाता हूं कि वल्लभनगर विधानसभा एवं भाजपा की आन बान शान के लिए हरसंभव प्रयास करता रहूँगा। हिम्मत सिंह झाला, भाजपा प्रत्याशी वल्लभनगर विधानसभा।">
                                                                Puja In</option>
                                                        </select>
                                                        <button name="import" type="submit"
                                                            class="btn btn-lg btn-light justify-content-center py-1 px-3 btn-tooltip"
                                                            data-original-title="Click to send an Whatsapp SMS"
                                                            title=""><em
                                                                class="icon ni ni-call-alt"></em>&nbsp;Whatsapp</button>

                                                    </div>
                                                </div>
                                            </form>
                                            <table class="table table-bordered table-responsive mt-3"
                                                id="panchayatList">
                                                <thead>
                                                    <tr>
                                                        <th>S.No.</th>
                                                        <th>File ID</th>
                                                        <th>लोकसभा</th>
                                                        <th>विधानसभा</th>
                                                        <th>बूथ</th>
                                                        <th>सेक्शन सं</th>
                                                        <th>मकान सं</th>
                                                        <th>नाम</th>
                                                        <th>उम</th>
                                                        <th>पिता / पति का नाम</th>
                                                        <th>सम्बन्ध</th>
                                                        <th>लिंग</th>
                                                        <th>वार्ड</th>
                                                        <th>आई डी क्रमांक</th>
                                                        <th>पोलिंग स्टेशन का नाम</th>
                                                        <th>Poling Station Name</th>
                                                        <th>Name</th>
                                                        <th>Father / Husband Name</th>
                                                        <th>Gender</th>
                                                        <th>Ward</th>
                                                        <th>पेशा</th>
                                                        <th>मोबाइल न०</th>
                                                        <th>व्हाट्सएप्प न०</th>
                                                        <th>प्रमुख मुद्दे</th>
                                                        <th>Rating Current Govt</th>
                                                        <th>Voted in 2019 लोकसभा</th>
                                                        <th>Voted in 2018 विधानसभा</th>
                                                        <th>2018 (पार्टी/सदस्य)</th>
                                                        <th>विचारधारा</th>
                                                        <th>कोरोना</th>
                                                        <th>लोकल कार्यकर्ता </th>
                                                        <th>2023 विधानसभा </th>
                                                        <th>जाति</th>
                                                        <th>श्रेणी</th>
                                                        <th>Surveyed By </th>
                                                        <th>Surveyed At </th>
                                                        <th>Action</th>
                                                        <th>
                                                            <div
                                                                class="custom-control custom-control-sm custom-checkbox notext">
                                                                <input type="checkbox" name="select_all"
                                                                    data-child="chk2" class="custom-control-input"
                                                                    id="selectAllMembers">
                                                                <label class="custom-control-label"
                                                                    for="selectAllMembers"></label>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>155-vallabhnagar</td>
                                                        <td>चित्तौड़गढ़</td>
                                                        <td>वल्लभनगर</td>
                                                        <td>63</td>
                                                        <td>6</td>
                                                        <td>90</td>
                                                        <td>दुगरेश</td>
                                                        <td>29</td>
                                                        <td>मेघराज</td>
                                                        <td>f</td>
                                                        <td>m</td>
                                                        <td>डांगियो का मौहल्ला,भमरासिया </td>
                                                        <td>WFX0224352</td>
                                                        <td>राजकीय उच्च प्राथमिक विधालय , भमरासिया </td>
                                                        <td>Government Upper Primary School, Bhamrasia, </td>
                                                        <td>DUGARESH</td>
                                                        <td>MEGHARAJ</td>
                                                        <td>M</td>
                                                        <td>DANGIYO KA MAUHALLA,BHAMARASIYA </td>
                                                        <td>मजदूर</td>
                                                        <td>8619574053</td>
                                                        <td>8619574053</td>
                                                        <td>सड़क,पानी सप्लाई,रोज़गार,जल निकासी,स्ट्रीट लाइट,कचरा
                                                            प्रबंधन, </td>
                                                        <td>बुरा</td>
                                                        <td>भारतीय जनता पार्टी </td>
                                                        <td>भारतीय जनता पार्टी </td>
                                                        <td>पार्टी</td>
                                                        <td>राम मंदिर,धारा 370 (कश्मीर), </td>
                                                        <td>मोदी सरकार </td>
                                                        <td>भारतीय जनता पार्टी </td>
                                                        <td>भारतीय जनता पार्टी </td>
                                                        <td>डांगी</td>
                                                        <td>ओबीसी</td>
                                                        <td>surveyor10 </td>
                                                        <td>2021-08-29 19:37:52 </td>
                                                        <td>
                                                            <a href="mahila_voter_edit.php" class="btn btn-icon btn-trigger btn-tooltip"
                                                                title="Edit"><em class="icon ni ni-edit"></em></a>
                                                            <a href="#!" class="btn btn-icon btn-trigger btn-tooltip"
                                                                title="Delete"><em class="icon ni ni-trash"></em></a>
                                                        </td>
                                                        <td>
                                                            <div
                                                                class="custom-control custom-control-sm custom-checkbox notext">
                                                                <input type="checkbox" class="custom-control-input chk2"
                                                                    name="mobile[]" id="9040" value="8619574053">
                                                                <label class="custom-control-label" for="9040"></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>155-vallabhnagar</td>
                                                        <td>चित्तौड़गढ़</td>
                                                        <td>वल्लभनगर</td>
                                                        <td>63</td>
                                                        <td>6</td>
                                                        <td>90</td>
                                                        <td>दुगरेश</td>
                                                        <td>29</td>
                                                        <td>मेघराज</td>
                                                        <td>f</td>
                                                        <td>m</td>
                                                        <td>डांगियो का मौहल्ला,भमरासिया </td>
                                                        <td>WFX0224352</td>
                                                        <td>राजकीय उच्च प्राथमिक विधालय , भमरासिया </td>
                                                        <td>Government Upper Primary School, Bhamrasia, </td>
                                                        <td>DUGARESH</td>
                                                        <td>MEGHARAJ</td>
                                                        <td>M</td>
                                                        <td>DANGIYO KA MAUHALLA,BHAMARASIYA </td>
                                                        <td>मजदूर</td>
                                                        <td>8619574053</td>
                                                        <td>8619574053</td>
                                                        <td>सड़क,पानी सप्लाई,रोज़गार,जल निकासी,स्ट्रीट लाइट,कचरा
                                                            प्रबंधन, </td>
                                                        <td>बुरा</td>
                                                        <td>भारतीय जनता पार्टी </td>
                                                        <td>भारतीय जनता पार्टी </td>
                                                        <td>पार्टी</td>
                                                        <td>राम मंदिर,धारा 370 (कश्मीर), </td>
                                                        <td>मोदी सरकार </td>
                                                        <td>भारतीय जनता पार्टी </td>
                                                        <td>भारतीय जनता पार्टी </td>
                                                        <td>डांगी</td>
                                                        <td>ओबीसी</td>
                                                        <td>surveyor10 </td>
                                                        <td>2021-08-29 19:37:52 </td>
                                                        <td>
                                                            <a href="#!" class="btn btn-icon btn-trigger btn-tooltip"
                                                                title="Edit"><em class="icon ni ni-edit"></em></a>
                                                            <a href="#!" class="btn btn-icon btn-trigger btn-tooltip"
                                                                title="Delete"><em class="icon ni ni-trash"></em></a>
                                                        </td>
                                                        <td>
                                                            <div
                                                                class="custom-control custom-control-sm custom-checkbox notext">
                                                                <input type="checkbox" class="custom-control-input chk2"
                                                                    name="mobile[]" id="9040" value="8619574053">
                                                                <label class="custom-control-label" for="9040"></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>155-vallabhnagar</td>
                                                        <td>चित्तौड़गढ़</td>
                                                        <td>वल्लभनगर</td>
                                                        <td>63</td>
                                                        <td>6</td>
                                                        <td>90</td>
                                                        <td>दुगरेश</td>
                                                        <td>29</td>
                                                        <td>मेघराज</td>
                                                        <td>f</td>
                                                        <td>m</td>
                                                        <td>डांगियो का मौहल्ला,भमरासिया </td>
                                                        <td>WFX0224352</td>
                                                        <td>राजकीय उच्च प्राथमिक विधालय , भमरासिया </td>
                                                        <td>Government Upper Primary School, Bhamrasia, </td>
                                                        <td>DUGARESH</td>
                                                        <td>MEGHARAJ</td>
                                                        <td>M</td>
                                                        <td>DANGIYO KA MAUHALLA,BHAMARASIYA </td>
                                                        <td>मजदूर</td>
                                                        <td>8619574053</td>
                                                        <td>8619574053</td>
                                                        <td>सड़क,पानी सप्लाई,रोज़गार,जल निकासी,स्ट्रीट लाइट,कचरा
                                                            प्रबंधन, </td>
                                                        <td>बुरा</td>
                                                        <td>भारतीय जनता पार्टी </td>
                                                        <td>भारतीय जनता पार्टी </td>
                                                        <td>पार्टी</td>
                                                        <td>राम मंदिर,धारा 370 (कश्मीर), </td>
                                                        <td>मोदी सरकार </td>
                                                        <td>भारतीय जनता पार्टी </td>
                                                        <td>भारतीय जनता पार्टी </td>
                                                        <td>डांगी</td>
                                                        <td>ओबीसी</td>
                                                        <td>surveyor10 </td>
                                                        <td>2021-08-29 19:37:52 </td>
                                                        <td>
                                                            <a href="#!" class="btn btn-icon btn-trigger btn-tooltip"
                                                                title="Edit"><em class="icon ni ni-edit"></em></a>
                                                            <a href="#!" class="btn btn-icon btn-trigger btn-tooltip"
                                                                title="Delete"><em class="icon ni ni-trash"></em></a>
                                                        </td>
                                                        <td>
                                                            <div
                                                                class="custom-control custom-control-sm custom-checkbox notext">
                                                                <input type="checkbox" class="custom-control-input chk2"
                                                                    name="mobile[]" id="9040" value="8619574053">
                                                                <label class="custom-control-label" for="9040"></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>155-vallabhnagar</td>
                                                        <td>चित्तौड़गढ़</td>
                                                        <td>वल्लभनगर</td>
                                                        <td>63</td>
                                                        <td>6</td>
                                                        <td>90</td>
                                                        <td>दुगरेश</td>
                                                        <td>29</td>
                                                        <td>मेघराज</td>
                                                        <td>f</td>
                                                        <td>m</td>
                                                        <td>डांगियो का मौहल्ला,भमरासिया </td>
                                                        <td>WFX0224352</td>
                                                        <td>राजकीय उच्च प्राथमिक विधालय , भमरासिया </td>
                                                        <td>Government Upper Primary School, Bhamrasia, </td>
                                                        <td>DUGARESH</td>
                                                        <td>MEGHARAJ</td>
                                                        <td>M</td>
                                                        <td>DANGIYO KA MAUHALLA,BHAMARASIYA </td>
                                                        <td>मजदूर</td>
                                                        <td>8619574053</td>
                                                        <td>8619574053</td>
                                                        <td>सड़क,पानी सप्लाई,रोज़गार,जल निकासी,स्ट्रीट लाइट,कचरा
                                                            प्रबंधन, </td>
                                                        <td>बुरा</td>
                                                        <td>भारतीय जनता पार्टी </td>
                                                        <td>भारतीय जनता पार्टी </td>
                                                        <td>पार्टी</td>
                                                        <td>राम मंदिर,धारा 370 (कश्मीर), </td>
                                                        <td>मोदी सरकार </td>
                                                        <td>भारतीय जनता पार्टी </td>
                                                        <td>भारतीय जनता पार्टी </td>
                                                        <td>डांगी</td>
                                                        <td>ओबीसी</td>
                                                        <td>surveyor10 </td>
                                                        <td>2021-08-29 19:37:52 </td>
                                                        <td>
                                                            <a href="#!" class="btn btn-icon btn-trigger btn-tooltip"
                                                                title="Edit"><em class="icon ni ni-edit"></em></a>
                                                            <a href="#!" class="btn btn-icon btn-trigger btn-tooltip"
                                                                title="Delete"><em class="icon ni ni-trash"></em></a>
                                                        </td>
                                                        <td>
                                                            <div
                                                                class="custom-control custom-control-sm custom-checkbox notext">
                                                                <input type="checkbox" class="custom-control-input chk2"
                                                                    name="mobile[]" id="9040" value="8619574053">
                                                                <label class="custom-control-label" for="9040"></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>155-vallabhnagar</td>
                                                        <td>चित्तौड़गढ़</td>
                                                        <td>वल्लभनगर</td>
                                                        <td>63</td>
                                                        <td>6</td>
                                                        <td>90</td>
                                                        <td>दुगरेश</td>
                                                        <td>29</td>
                                                        <td>मेघराज</td>
                                                        <td>f</td>
                                                        <td>m</td>
                                                        <td>डांगियो का मौहल्ला,भमरासिया </td>
                                                        <td>WFX0224352</td>
                                                        <td>राजकीय उच्च प्राथमिक विधालय , भमरासिया </td>
                                                        <td>Government Upper Primary School, Bhamrasia, </td>
                                                        <td>DUGARESH</td>
                                                        <td>MEGHARAJ</td>
                                                        <td>M</td>
                                                        <td>DANGIYO KA MAUHALLA,BHAMARASIYA </td>
                                                        <td>मजदूर</td>
                                                        <td>8619574053</td>
                                                        <td>8619574053</td>
                                                        <td>सड़क,पानी सप्लाई,रोज़गार,जल निकासी,स्ट्रीट लाइट,कचरा
                                                            प्रबंधन, </td>
                                                        <td>बुरा</td>
                                                        <td>भारतीय जनता पार्टी </td>
                                                        <td>भारतीय जनता पार्टी </td>
                                                        <td>पार्टी</td>
                                                        <td>राम मंदिर,धारा 370 (कश्मीर), </td>
                                                        <td>मोदी सरकार </td>
                                                        <td>भारतीय जनता पार्टी </td>
                                                        <td>भारतीय जनता पार्टी </td>
                                                        <td>डांगी</td>
                                                        <td>ओबीसी</td>
                                                        <td>surveyor10 </td>
                                                        <td>2021-08-29 19:37:52 </td>
                                                        <td>
                                                            <a href="#!" class="btn btn-icon btn-trigger btn-tooltip"
                                                                title="Edit"><em class="icon ni ni-edit"></em></a>
                                                            <a href="#!" class="btn btn-icon btn-trigger btn-tooltip"
                                                                title="Delete"><em class="icon ni ni-trash"></em></a>
                                                        </td>
                                                        <td>
                                                            <div
                                                                class="custom-control custom-control-sm custom-checkbox notext">
                                                                <input type="checkbox" class="custom-control-input chk2"
                                                                    name="mobile[]" id="9040" value="8619574053">
                                                                <label class="custom-control-label" for="9040"></label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div><!-- .card-preview -->
                                </div> <!-- nk-block -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content @e -->
            </div>
            <!-- wrap @e -->
        </div>
        <!-- main @e -->
        <?php include_once 'footer.php'; ?>
    </div>
    <!-- app-root @e -->
    <script src="assets/js/bundle.js?ver=2.2.0"></script>
    <script src="assets/js/scripts.js?ver=2.2.0"></script>
    <script src="assets/js/charts/chart-ecommerce.js?ver=2.2.0"></script>
</body>

</html>