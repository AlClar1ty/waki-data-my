function capitalize(string) { //INDONESIA -> Indonesia
    return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
}

var actionDelete = $("#actionDelete").prop('action');
var actionEdit = $("#actionEdit").prop('action');

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//      METHOD - METHOD KHUSUS EDIT DATA MASTER YG BERGUNA UNTUK NGAMBIL DATA DARI TABLE SAJA
//
////////////////////////////////////////////////////////////////////////////////////////

$("#change-password").click(function(e) {
    $("#modal-ChangePassword").modal("show");
});

//function untuk mengambil data dari table DATA OUTSITE
function GetListDataOutsite(idx){
    var element_table = document.getElementsByName('ListDataOutsite');
    var element_tableRows = element_table[0].rows;
    var dataoutsite_reg_date = element_tableRows[idx].cells[0].innerHTML;
    var dataoutsite_kode = element_tableRows[idx].cells[1].innerHTML;
    var dataoutsite_nama = element_tableRows[idx].cells[2].innerHTML;
    var dataoutsite_location = element_tableRows[idx].cells[3].innerHTML;
    var dataoutsite_phone = element_tableRows[idx].cells[4].innerHTML;
    var dataoutsite_province = element_tableRows[idx].cells[6].innerHTML;
    var dataoutsite_district = element_tableRows[idx].cells[7].innerHTML;
    var dataoutsite_country = element_tableRows[idx].cells[8].innerHTML;
    var dataoutsite_branch = element_tableRows[idx].cells[9].innerHTML;
    var dataoutsite_cso = element_tableRows[idx].cells[10].innerHTML;
    var dataoutsite_typecustId = element_tableRows[idx].cells[11].innerHTML;
    
    return {kode : dataoutsite_kode, nama : dataoutsite_nama, location : dataoutsite_location, country : dataoutsite_country, branch : dataoutsite_branch, cso : dataoutsite_cso,
        phone : dataoutsite_phone, reg_date : dataoutsite_reg_date, province : dataoutsite_province, district : dataoutsite_district, typecust : dataoutsite_typecustId};
}

//function untuk mengambil data dari table DATA THERAPY
function GetListDataTherapy(idx){
    var element_table = document.getElementsByName('ListDataTherapy');
    var element_tableRows = element_table[0].rows;
    var datatherapy_reg_date = element_tableRows[idx].cells[0].innerHTML;
    var datatherapy_kode = element_tableRows[idx].cells[1].innerHTML;
    var datatherapy_nama = element_tableRows[idx].cells[2].innerHTML;
    var datatherapy_phone = element_tableRows[idx].cells[3].innerHTML;
    var datatherapy_address = element_tableRows[idx].cells[6].innerHTML;
    var datatherapy_province = element_tableRows[idx].cells[7].innerHTML;
    var datatherapy_district = element_tableRows[idx].cells[8].innerHTML;
    var datatherapy_country = element_tableRows[idx].cells[9].innerHTML;
    var datatherapy_cso = element_tableRows[idx].cells[10].innerHTML;
    var datatherapy_typecustId = element_tableRows[idx].cells[11].innerHTML;
    var datatherapy_branch = element_tableRows[idx].cells[12].innerHTML;
    
    return {kode : datatherapy_kode, nama : datatherapy_nama, address : datatherapy_address, country : datatherapy_country, branch : datatherapy_branch, cso : datatherapy_cso,
        phone : datatherapy_phone, reg_date : datatherapy_reg_date, province : datatherapy_province, district : datatherapy_district, typecust : datatherapy_typecustId};
}

//function untuk mengambil data dari table MPC
function GetListMpc(idx){
    var element_table = document.getElementsByName('ListMpc');
    var element_tableRows = element_table[0].rows;
    var mpc_reg_date = element_tableRows[idx].cells[0].innerHTML;
    var mpc_member_no = element_tableRows[idx].cells[1].innerHTML;
    var mpc_name = element_tableRows[idx].cells[2].innerHTML;
    var mpc_mobile_phone = element_tableRows[idx].cells[3].innerHTML;
    var mpc_branch_name = element_tableRows[idx].cells[4].innerHTML;
    var mpc_idcard = element_tableRows[idx].cells[5].innerHTML;
    var mpc_status = element_tableRows[idx].cells[6].innerHTML;
    var mpc_gender = element_tableRows[idx].cells[7].innerHTML;
    var mpc_birth_date = element_tableRows[idx].cells[8].innerHTML;
    var mpc_address = element_tableRows[idx].cells[9].innerHTML;
    var mpc_postcode = element_tableRows[idx].cells[10].innerHTML;
    var mpc_city = element_tableRows[idx].cells[11].innerHTML;
    var mpc_state = element_tableRows[idx].cells[12].innerHTML;
    var mpc_house_phone = element_tableRows[idx].cells[13].innerHTML;
    var mpc_contact_method = element_tableRows[idx].cells[14].innerHTML;
    var mpc_fb_name = element_tableRows[idx].cells[15].innerHTML;
    var mpc_email = element_tableRows[idx].cells[16].innerHTML;
    var mpc_user_id = element_tableRows[idx].cells[17].innerHTML;
    var mpc_branch_id = element_tableRows[idx].cells[18].innerHTML;
    var mpc_country = element_tableRows[idx].cells[19].innerHTML;

    return {reg_date : mpc_reg_date, member_no : mpc_member_no, name : mpc_name, mobile_phone : mpc_mobile_phone, branch_name : mpc_branch_name, idcard : mpc_idcard, 
        status : mpc_status, gender : mpc_gender, birth_date : mpc_birth_date, address : mpc_address, postcode : mpc_postcode, city : mpc_city, state : mpc_state, 
        country : mpc_country, house_phone : mpc_house_phone, contact_method : mpc_contact_method, fb_name : mpc_fb_name, email : mpc_email, user_id : mpc_user_id, branch_id : mpc_branch_id};
}

//untuk menampilkan modal hapus data OUTSITE dan menampilkan data mana yang mau di hapus
// $(".btn-deleteDataOutsite").click(function(e) {
//     var dataOutsite = GetListDataOutsite(this.name);
//     document.getElementById("txt-delete-dataoutsite").innerHTML = "Do you want to delete "+ dataOutsite.kode +" - "+ dataOutsite.nama +"?";
//     document.getElementById("btn-confirmDeleteDataOutsite").value = this.value;
//     $("#actionDelete").prop('action', actionDelete+'/'+this.value);
//     $("#modal-DeleteConfirm").modal("show");
// });


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//      METHOD - METHOD KHUSUS USER
//
//function untuk mengambil data dari table USER
function GetListUserData(idx){
    var element_table = document.getElementsByName('collection');
    var element_tableRows = element_table[0].rows;
    var user_kode = element_tableRows[idx].cells[0].innerHTML;
    var user_nama = element_tableRows[idx].cells[1].innerHTML;
    var user_username = element_tableRows[idx].cells[2].innerHTML;
    var user_role = element_tableRows[idx].cells[3].innerHTML;
    var user_country = element_tableRows[idx].cells[4].innerHTML;
    var user_branch = element_tableRows[idx].cells[5].innerHTML;
    var user_permissions = element_tableRows[idx].cells[6].innerHTML;
    
    return {kode : user_kode, nama : user_nama, username : user_username, role : user_role, country : user_country, 
        branch : user_branch, permissions : user_permissions};
}

//untuk menampilkan modal hapus data USER dan menampilkan data mana yang mau di hapus
$(".btn-deleteUser").click(function(e) {
        var dataUser = GetListUserData(this.name);
        document.getElementById("txt-delete-user").innerHTML = "Do you want to delete "+ dataUser.kode +" - "+ dataUser.nama +"?";
        document.getElementById("btn-confirmDeleteUser").value = this.value;
        $("#actionDelete").prop('action', actionDelete+'/'+this.value);
        $("#modal-DeleteConfirm").modal("show");
});

//untuk menampilkan modal edit data USER dan menampilkan data mana yg mau di edit
$(".btn-editUser").click(function(e) {
    //ResetBranch();
    ResetPermission();

    var dataUser = GetListUserData(this.name);
    document.getElementById("txtkode-user").value = dataUser.kode;
    document.getElementById("txtnama-user").value = dataUser.nama;
    document.getElementById("txtusername-user").value = dataUser.username;
    document.getElementById("txtcountry-user").value = dataUser.country;
    document.getElementById("txtbranch-user").value = dataUser.branch;
    document.getElementById("btn-confirmUpdateUser").value = this.value;
    $("#actionEdit").prop('action', actionEdit+'/'+this.value);

    var permissions = JSON.parse(dataUser.permissions, true);
    for(let item in permissions)
    {
        $("#"+item).prop('name', "permissions["+item+"]");
        $("#"+item).prop('checked', permissions[item]);

        //MPC
        if(item == "browse-mpc" && permissions[item] == true)
        {
            $("#check-DeleteMPC").addClass("d-inline-block");
            $("#check-EditMPC").addClass("d-inline-block");
        }

        else if(item == "all-branch-mpc" && permissions[item] == true)
        {
            $("#check-AllCountryMPC").addClass("d-inline-block");
        }

        //DATA UNDANGAN
        else if(item == "browse-data-undangan" && permissions[item] == true)
        {
            $("#check-DeleteDataUndangan").addClass("d-inline-block");
            $("#check-EditDataUndangan").addClass("d-inline-block");
        }

        else if(item == "all-branch-data-undangan" && permissions[item] == true)
        {
            $("#check-AllCountryDataUndangan").addClass("d-inline-block");
        }

        //DATA OUTSITE
        else if(item == "browse-data-outsite" && permissions[item] == true)
        {
            $("#check-DeleteDataOutsite").addClass("d-inline-block");
            $("#check-EditDataOutsite").addClass("d-inline-block");
        }

        else if(item == "all-branch-data-outsite" && permissions[item] == true)
        {
            $("#check-AllCountryDataOutsite").addClass("d-inline-block");
        }

        //DATA THERAPY
        else if(item == "browse-data-therapy" && permissions[item] == true)
        {
            $("#check-DeleteDataTherapy").addClass("d-inline-block");
            $("#check-EditDataTherapy").addClass("d-inline-block");
        }

        else if(item == "all-branch-data-therapy" && permissions[item] == true)
        {
            $("#check-AllCountryDataTherapy").addClass("d-inline-block");
        }

        //TYPE CUST
        else if(item == "browse-type-cust" && permissions[item] == true)
        {
            $("#check-DeleteTypeCust").addClass("d-inline-block");
            $("#check-EditTypeCust").addClass("d-inline-block");
        }

        //CSO
        else if(item == "browse-cso" && permissions[item] == true)
        {
            $("#check-DeleteCSO").addClass("d-inline-block");
            $("#check-EditCSO").addClass("d-inline-block");
        }

        else if(item == "all-branch-cso" && permissions[item] == true)
        {
            $("#check-AllCountryCSO").addClass("d-inline-block");
        }

        //BRANCH
        else if(item == "browse-branch" && permissions[item] == true)
        {
            $("#check-DeleteBranch").addClass("d-inline-block");
            $("#check-EditBranch").addClass("d-inline-block");
        }

        //USER
        else if(item == "browse-user" && permissions[item] == true)
        {
            $("#check-DeleteUser").addClass("d-inline-block");
            $("#check-EditUser").addClass("d-inline-block");
        }

        else if(item == "all-branch-user" && permissions[item] == true)
        {
            $("#check-AllCountryUser").addClass("d-inline-block");
        }
    }

    $("#modal-UpdateForm").modal("show");
});

//Untuk reset permissions ketika close modal
function ResetPermission()
{
    //MPC
    $("#check-EditMPC").removeClass("d-inline-block");
    $("#check-DeleteMPC").removeClass("d-inline-block");

    $("#check-AllCountryMPC").removeClass("d-inline-block");

    //DATA UNDANGAN
    $("#check-EditDataUndangan").removeClass("d-inline-block");
    $("#check-DeleteDataUndangan").removeClass("d-inline-block");

    $("#check-AllCountryDataUndangan").removeClass("d-inline-block");

    //DATA OUTSITE
    $("#check-EditDataOutsite").removeClass("d-inline-block");
    $("#check-DeleteDataOutsite").removeClass("d-inline-block");

    $("#check-AllCountryDataOutsite").removeClass("d-inline-block");

    //DATA THERAPY
    $("#check-EditDataTherapy").removeClass("d-inline-block");
    $("#check-DeleteDataTherapy").removeClass("d-inline-block");

    $("#check-AllCountryDataTherapy").removeClass("d-inline-block");

    //TYPE CUST
    $("#check-EditTypeCust").removeClass("d-inline-block");
    $("#check-DeleteTypeCust").removeClass("d-inline-block");

    //CSO
    $("#check-EditCSO").removeClass("d-inline-block");
    $("#check-DeleteCSO").removeClass("d-inline-block");

    $("#check-AllCountryCSO").removeClass("d-inline-block");

    //BRANCH
    $("#check-EditBranch").removeClass("d-inline-block");
    $("#check-DeleteBranch").removeClass("d-inline-block");

    //USER
    $("#check-DeleteUser").removeClass("d-inline-block");
    $("#check-EditUser").removeClass("d-inline-block");

    $("#check-AllCountryUser").removeClass("d-inline-block");
}

//method berbeda jangan di rubah
//function" di bawah ini berguna untuk khusus user role
//Jika Browse di-check, maka Edit dan Delete akan muncul, berlaku sebaliknya
//Jika AllBranch di-check, maka AllCountry akan muncul, berlaku sebaliknya
//MPC
$("#group-mpc .div-CheckboxGroup #browse-mpc").click(function(e) {
        $("#check-DeleteMPC").toggleClass("d-inline-block");
        $("#check-EditMPC").toggleClass("d-inline-block");
        $("#edit-mpc").prop('checked', false);
        $("#delete-mpc").prop('checked', false);
});
$("#group-mpc .div-CheckboxGroup #all-branch-mpc").click(function(e) {
        $("#check-AllCountryMPC").toggleClass("d-inline-block");
        $("#all-country-mpc").prop('checked', false);
});

//DATA UNDANGAN
$("#group-data-undangan .div-CheckboxGroup #browse-data-undangan").click(function(e) {
        $("#check-DeleteDataUndangan").toggleClass("d-inline-block");
        $("#check-EditDataUndangan").toggleClass("d-inline-block");
        $("#edit-data-undangan").prop('checked', false);
        $("#delete-data-undangan").prop('checked', false);
});
$("#group-data-undangan .div-CheckboxGroup #all-branch-data-undangan").click(function(e) {
        $("#check-AllCountryDataUndangan").toggleClass("d-inline-block");
        $("#all-country-data-undangan").prop('checked', false);
});

//DATA OUTSITE
$("#group-data-outsite .div-CheckboxGroup #browse-data-outsite").click(function(e) {
        $("#check-DeleteDataOutsite").toggleClass("d-inline-block");
        $("#check-EditDataOutsite").toggleClass("d-inline-block");
        $("#edit-data-outsite").prop('checked', false);
        $("#delete-data-outsite").prop('checked', false);
});
$("#group-data-outsite .div-CheckboxGroup #all-branch-data-outsite").click(function(e) {
        $("#check-AllCountryDataOutsite").toggleClass("d-inline-block");
        $("#all-country-data-outsite").prop('checked', false);
});

//DATA THERAPY
$("#group-data-therapy .div-CheckboxGroup #browse-data-therapy").click(function(e) {
        $("#check-DeleteDataTherapy").toggleClass("d-inline-block");
        $("#check-EditDataTherapy").toggleClass("d-inline-block");
        $("#edit-data-therapy").prop('checked', false);
        $("#delete-data-therapy").prop('checked', false);
});
$("#group-data-therapy .div-CheckboxGroup #all-branch-data-therapy").click(function(e) {
        $("#check-AllCountryDataTherapy").toggleClass("d-inline-block");
        $("#all-country-data-therapy").prop('checked', false);
});

//TYPE CUST
$("#group-type-cust .div-CheckboxGroup #browse-type-cust").click(function(e) {
        $("#check-DeleteTypeCust").toggleClass("d-inline-block");
        $("#check-EditTypeCust").toggleClass("d-inline-block");
        $("#edit-type-cust").prop('checked', false);
        $("#delete-type-cust").prop('checked', false);
});

//CSO
$("#group-cso .div-CheckboxGroup #browse-cso").click(function(e) {
        $("#check-DeleteCSO").toggleClass("d-inline-block");
        $("#check-EditCSO").toggleClass("d-inline-block");
        $("#edit-cso").prop('checked', false);
        $("#delete-cso").prop('checked', false);
});
$("#group-cso .div-CheckboxGroup #all-branch-cso").click(function(e) {
        $("#check-AllCountryCSO").toggleClass("d-inline-block");
        $("#all-country-cso").prop('checked', false);
});

//BRANCH
$("#group-branch .div-CheckboxGroup #browse-branch").click(function(e) {
        $("#check-DeleteBranch").toggleClass("d-inline-block");
        $("#check-EditBranch").toggleClass("d-inline-block");
        $("#edit-branch").prop('checked', false);
        $("#delete-branch").prop('checked', false);
});

//USER
$("#group-user .div-CheckboxGroup #browse-user").click(function(e) {
        $("#check-DeleteUser").toggleClass("d-inline-block");
        $("#check-EditUser").toggleClass("d-inline-block");
        $("#edit-user").prop('checked', false);
        $("#delete-user").prop('checked', false);
});
$("#group-user .div-CheckboxGroup #all-branch-user").click(function(e) {
        $("#check-AllCountryUser").toggleClass("d-inline-block");
        $("#all-country-user").prop('checked', false);
});


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//      METHOD - METHOD KHUSUS BRANCH
//
//function untuk mengambil data dari table BRANCH
function GetListBranchData(idx){
    var element_table = document.getElementsByName('collection');
    var element_tableRows = element_table[0].rows;
    var branch_kode = element_tableRows[idx].cells[0].innerHTML;
    var branch_nama = element_tableRows[idx].cells[1].innerHTML;
    var branch_country = element_tableRows[idx].cells[2].innerHTML;
    
    return {kode : branch_kode, nama : branch_nama, country : branch_country};
}

//untuk menampilkan modal hapus data BRANCH dan menampilkan data mana yang mau di hapus
$(".btn-deleteBranch").click(function(e) {
    var dataBranch = GetListBranchData(this.name);
    document.getElementById("txt-delete-branch").innerHTML = "Do you want to delete "+ dataBranch.kode +" - "+ dataBranch.nama +"?";
    document.getElementById("btn-confirmDeleteBranch").value = this.value;
    $("#actionDelete").prop('action', actionDelete+'/'+this.value);
    $("#modal-DeleteConfirm").modal("show");
});

//untuk menampilkan modal edit data BRANCH dan menampilkan data mana yg mau di edit
$(".btn-editBranch").click(function(e) {
    var dataBranch = GetListBranchData(this.name);
    document.getElementById("txtkode-branch").value = dataBranch.kode;
    document.getElementById("txtnama-branch").value = dataBranch.nama;
    document.getElementById("txtcountry-branch").value = dataBranch.country;
    document.getElementById("btn-confirmUpdateBranch").value = 
    this.value;
    $("#actionEdit").prop('action', actionEdit+'/'+this.value);
    $("#modal-UpdateForm").modal("show");
});

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//      METHOD - METHOD KHUSUS TYPE CUST (MASTER DATA TYPE)
//
//function untuk mengambil data dari table TYPE CUST
function GetListTypeCustData(idx){
    var element_table = document.getElementsByName('collection');
    var element_tableRows = element_table[0].rows;
    var type_cust_nama = element_tableRows[idx].cells[0].innerHTML;
    var type_cust_type_input = element_tableRows[idx].cells[1].innerHTML;
    
    return {nama : type_cust_nama, type_input : type_cust_type_input};
}

//untuk menampilkan modal hapus data TYPE CUST dan menampilkan data mana yang mau di hapus
$(".btn-deleteTypeCust").click(function(e) {
    var dataTypeCust = GetListTypeCustData(this.name);
    document.getElementById("txt-delete-type-cust").innerHTML = "Do you want to delete "+ dataTypeCust.nama +" - "+ dataTypeCust.type_input +"?";
    document.getElementById("btn-confirmDeleteTypeCust").value = this.value;
    $("#actionDelete").prop('action', actionDelete+'/'+this.value);
    $("#modal-DeleteConfirm").modal("show");
});

//untuk menampilkan modal edit data TYPE CUST dan menampilkan data mana yg mau di edit
$(".btn-editTypeCust").click(function(e) {
    var dataTypeCust = GetListTypeCustData(this.name);
    document.getElementById("txtnama-type-cust").value = dataTypeCust.nama;
    document.getElementById("txttypeinput-type-cust").value = dataTypeCust.type_input;
    document.getElementById("btn-confirmUpdateTypeCust").value = 
    this.value;
    $("#actionEdit").prop('action', actionEdit+'/'+this.value);
    $("#modal-UpdateForm").modal("show");
});

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(window.matchMedia("(max-width: 768px)").matches){
    $(".pagination-wrapper").addClass("pagination-sm");
}

if(window.matchMedia("(min-width: 768px)").matches){
    $(".pagination-wrapper").removeClass("pagination-sm");
}

function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode != 46 &&(charCode < 48 || charCode > 57)))
        return false;
    return true;
}

function isBankAccount(evt){
    if(event.target.value.length == 3)
    {
        event.target.value += ".";
    }
    if(event.target.value.length == 7)
    {
        event.target.value += ".";
    }
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//      METHOD KHUSUS COMBOBOX OFFLINE KOTA
//
//function untuk mengambil data dari file php masuk ke option setelah di pilihnya option provinsi
$("#province").change( function (){
    var pilihanProvinsi = this.value;
    var isiOption = "";

    var $el = $("#district");
    $el.empty();
    $.get( "etc/select-"+unescape(pilihanProvinsi)+".php", function( data ) {
      $el.append(data); //Folder "etc" terdapat di dalam "public"
    });
});

$("#txtprovince-member").change( function (){
    var pilihanProvinsi = this.value;
    var isiOption = "";

    var $el = $("#txtdistrict-member");
    $el.empty();
    $.get( "etc/select-"+unescape(pilihanProvinsi)+".php", function( data ) {
      $el.append(data);
    });
});

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//      METHOD - METHOD KHUSUS CSO
//
//function untuk mengambil data dari table CSO
function GetListCsoData(idx){
    var element_table = document.getElementsByName('collection');
    var element_tableRows = element_table[0].rows;
    var cso_reg_date = element_tableRows[idx].cells[0].innerHTML;
    var cso_kode = element_tableRows[idx].cells[1].innerHTML;
    var cso_nama = element_tableRows[idx].cells[2].innerHTML;
    var cso_address = element_tableRows[idx].cells[3].innerHTML;
    var cso_province = element_tableRows[idx].cells[4].innerHTML;
    var cso_district = element_tableRows[idx].cells[5].innerHTML;
    var cso_country = element_tableRows[idx].cells[6].innerHTML;
    var cso_branch = element_tableRows[idx].cells[7].innerHTML;
    var cso_phone = element_tableRows[idx].cells[8].innerHTML;
    var cso_komisi = element_tableRows[idx].cells[9].innerHTML;
    var cso_no_rekening = element_tableRows[idx].cells[10].innerHTML;
    var cso_unreg_date = element_tableRows[idx].cells[11].innerHTML;
    
    return {kode : cso_kode, nama : cso_nama, address : cso_address, country : cso_country, branch : cso_branch, 
        phone : cso_phone, komisi : cso_komisi, reg_date : cso_reg_date, province : cso_province, district : cso_district, no_rekening : cso_no_rekening,
        unreg_date : cso_unreg_date};
}

//untuk menampilkan modal hapus data CSO dan menampilkan data mana yang mau di hapus
$(".btn-deleteCso").click(function(e) {
    var dataCso = GetListCsoData(this.name);
    document.getElementById("txt-delete-cso").innerHTML = "Do you want to delete "+ dataCso.kode +" - "+ dataCso.nama +"?";
    document.getElementById("btn-confirmDeleteCso").value = this.value;
    $("#actionDelete").prop('action', actionDelete+'/'+this.value);
    $("#modal-DeleteConfirm").modal("show");
});


//untuk menampilkan modal edit data CSO dan menampilkan data mana yg mau di edit
$(".btn-editCso").click(function(e) {
    var dataCso = GetListCsoData(this.name);
    document.getElementById("txtregdate-cso").value = dataCso.reg_date;
    document.getElementById("txtkode-cso").value = dataCso.kode;
    document.getElementById("txtnama-cso").value = dataCso.nama;
    document.getElementById("txtaddress-cso").value = dataCso.address;
    document.getElementById("txtcountry-cso").value = dataCso.country;
    document.getElementById("txtprovince-cso").value = dataCso.province;
    document.getElementById("txtphone-cso").value = dataCso.phone;
    document.getElementById("txtkomisi-cso").value = dataCso.komisi;
    document.getElementById("txtnorekening-cso").value = dataCso.no_rekening;
    document.getElementById("txtunregdate-cso").value = dataCso.unreg_date;
    document.getElementById("btn-confirmUpdateCso").value = this.value;
    $("#actionEdit").prop('action', actionEdit+'/'+this.value);

    var pilihanProvinsi = dataCso.province;
    var isiOption = "";

    var $el = $("#txtdistrict-cso");
    $el.empty();
    $.get( "etc/select-"+unescape(pilihanProvinsi)+".php", function( data ) {
      $el.append(data);
    });
    setTimeout(function(){
        document.getElementById("txtdistrict-cso").value = dataCso.district;
    }, 300);
    $("#modal-UpdateForm").modal("show");
});

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
//      METHOD - METHOD KHUSUS PRINT REPORT
//
//function untuk passing kan value btn apa yang diklik

$("#btn-global, #btn-detail, #btn-umur").click(function(e){
    e.preventDefault();
    $("#modal-PrintReport").modal("show");
    if($(this).attr("value") == "2") //Umur
    {
        $(".ageGroup").css("display", "block");
    }
    else
    {
        $(".ageGroup").css("display", "none");
    }
    $("#btn-print").val($(this).attr("value"));
});