if (localStorage['success'] == 'true') {
    documentч.getElementById('textSave').style.display = 'inline-block';
    setTimeout(function(){
        // document.getElementById('textSave').style.display = 'none';
        $('#textSave').fadeOut('fast')
    },2000);
}

localStorage['success'] = 'false';
var url = window.location.href;
var pieces = url.split(/[=]+/);
if(pieces[pieces.length-1] == 'true') {
    localStorage['success'] = 'true';
    document.location.href = "http://erp.sergeysudakov.ru/storage/add";

}


// document.getElementById('value').style.color = "#CCCCCC";
// $("#value").prop('disabled', 'disabled');

document.getElementById('selectStatus').style.color = "#CCCCCC";
document.getElementById('selectStatus_send').value = "null";
$("#selectStatus").prop('disabled', 'disabled');


document.getElementById('type_img_name').value = "empty.jpg";
document.getElementById('name_img_name').value = "empty.jpg";
document.getElementById('type_title_send').value = "";
document.getElementById('type_desc_send').value = "";

document.getElementById('name_title_send').value = "";
document.getElementById('name_desc_send').value = "";
document.getElementById('name_type_send').value = "";
document.getElementById('date_send').value = "";
document.getElementById('time_send').value = "";


clock();
var arrow = document.getElementById('arrow');
var arrowName = document.getElementById('arroww');

var visible = false;

var visibleNames = false;

var usingName = true;

var showGreyNamesAllowed = true;

var type_selected = false;
var name_selected = false;

var testStatus = false;

var isSelectedName2;

var greys_types = document.getElementsByName('grey_table_types');
var greys_names = document.getElementsByName('grey_table_names');

isFormFilled = false;

var names = ['Щит под дерево с просветом', 'Квадрат под дерево с просветом', 'Круг под дерево с просветом', 'Щит под дерево с орнаментом', 'Квадрат под дерево с орнаментом', 'Круг под дерево с орнаментом', '8 граней с орнаментом', '8 граней с желобом', '8 граней под гравировку', 'Спаси и сохрани с надписью', 'Спаси и сохрани основа с орнаментом', 'Спаси и сохрани под гравировку', 'Щит европа стандартный', 'Щит европа с орнаментом', 'Круг косичка', 'Квадрат косичка', 'Прямоугольная косичка', 'Прямоугольник готика под бриллиант', 'под премиум круглый', 'под премиум квадратный', 'Щит ФСБ', 'Омниа квадрат', 'Омниа круг', 'Щит облегченный', 'Фантом', 'Созвездие круг большой', 'Созвездие фон', 'Круг малый', 'Пупырки', 'под винтажный куб', 'Геральдика под монограмму', 'Геральдика классическая', 'Геральдика ребристая с камнями', 'Геральдика под эмаль со сферами по периметру', 'Геральдика под эмаль с орнаментом по ободку', 'Геральдика Щит и меч', 'Круг орел', 'Фантом', 'под премиум круглый', 'под премиум квадратный', 'Лев плоский (царь зверей)', 'Щит под гравировку', 'Лев классический (царь зверей)', 'Лев античный (царь зверей)', 'Тигр (царь зверей)', 'Лис (царь зверей)', 'Бульдог (царь зверей)', 'Волк (царь зверей)', 'Медведь (царь зверей)', '8 граней под гравировку большая', '8 граней под гравировку малая', 'Грани характера под гравировку круглая', 'Грани характера Звери', 'Грани характера Георгий победоносец', 'Грани характера Рыбы', 'Грани характера Оружие', 'Созвездие Круг большой', 'Созвездие Круг малый', 'Фантом', 'под винтажный куб', 'Лев плоский (царь зверей)', 'Цельнолитая рефленая', 'малая поворотная', 'Задняя часть малой поворотной ножки', 'Пружина малой поворотной ножки', 'Большая поворотная', 'Задняя часть большой поворотной ножки', 'Пружина большой поворотной ножки'];

var names2 = ['Фантом (задняя часть с малой поворотной ножкой)','Фантом основа с покрытием','Созвездие (основа + задняя часть с малой поворотной ножкой)','Круг малый  (основа + задняя часть с малой поворотной ножкой)','Щит под дерево с орнаментом (основа + ножка)','Круг под дерево с орнаментом (основа + ножка)','Квадрат под дерево с орнаментом (основа + ножка)','Щит под дерево с просветом  (основа + ножка)','Круг под дерево с просветом (основа + ножка)', 'Квадрат под дерево с просветом (основа + ножка)', '8 граней с орнаментом (основа + ножка)', '8 граней с орнаментом (основа + ножка)', '8 граней с орнаментом (основа + ножка)', 'Щит европа стандартный (основа + ножка)','Щит европа стандартный (основа + ножка)','Щит европа стандартный (основа + ножка)', 'Прямоугольник косичка (основа + ножка)', 'Круг косичка (основа + ножка)', 'Спаси и сохрани с орнаментом (основа + ножка)','Спаси и сохрани под гравировку (основа + ножка)','Спаси и сохрани с надписью (основа + ножка)', 'Премиум квадратный (основа + ножка)','Накладка под премиум квадратный (отполированная)','Премиум круглый (основа + ножка)','Накладка под премиум круглый (отполированная)','Винтажный куб (основа + ножка)','Омниа круг (основа + ножка)','Омниа квадрат (основа + ножка)','Прямоугольник готика под бриллиант (основа + ножка)'];

var names_short = ['Щит под дерево', 'Квадрат под дерево', 'Круг под дерево', 'Щит под дерево', 'Квадрат под дерево', 'Круг под дерево', '8 граней', '8 граней', '8 граней', 'Спаси и сохрани', 'Спаси и сохрани', 'Спаси и сохрани', 'Щит европа', 'Щит европа', 'Круг косичка', 'Квадрат косичка', 'Прямоугольная косичка', 'Прямоугольник готика', 'под премиум', 'под премиум', 'Щит ФСБ', 'Омниа квадрат', 'Омниа круг', 'Щит облегченный', 'Фантом', 'Созвездие круг', 'Созвездие фон', 'Круг малый', 'Пупырки', 'под винтажный', 'Геральдика', 'Геральдика классическая', 'Геральдика ребристая', 'Геральдика под эмаль', 'Геральдика под эмаль', 'Геральдика', 'Круг орел', 'Фантом', 'под премиум круглый', 'под премиум квадратный', 'Лев плоский', 'Щит под гравировку', 'Лев классический', 'Лев античный', 'Тигр', 'Лис', 'Бульдог', 'Волк', 'Медведь', '8 граней под гравировку', '8 граней под гравировку', 'Грани характера', 'Грани характера', 'Грани характера', 'Грани характера', 'Грани характера', 'Созвездие', 'Созвездие', 'Фантом', 'под винтажный куб', 'Лев плоский', 'Цельнолитая рефленая', 'малая поворотная', 'Задняя часть малой поворотной ножки', 'Пружина малой поворотной ножки', 'Большая поворотная', 'Задняя часть большой поворотной ножки', 'Пружина большой поворотной ножки'];


var descs = ['с просветом', ' с просветом', 'с просветом', 'с орнаментом', 'с орнаментом', 'с орнаментом', 'с орнаментом', 'с желобом', 'под гравировку', 'с надписью', 'основа с орнаментом', 'под гравировку', 'стандартный', 'с орнаментом', ' ', ' ', ' ', 'под бриллиант', 'круглый', 'квадратный', ' ', ' ', ' ', ' ', ' ', 'большой', ' ', ' ', ' ', ' ', 'куб', 'под монограмму', 'с камнями', 'со сферами по периметру', 'с орнаментом по ободку', 'Щит и меч', ' ', ' ', ' ', ' ', '(царь зверей)', ' ', '(царь зверей)', '(царь зверей)', '(царь зверей)', '(царь зверей)', '(царь зверей)', '(царь зверей)', '(царь зверей)', 'большая', 'малая', 'под гравировку круглая', 'Звери', 'Георгий победоносец', 'Рыбы', 'Оружие', 'Круг большой', 'Круг малый', ' ', ' ', '(царь зверей)', ' ', ' ', ' ', ' ', ' ', ' ', ' '];


hide_greys_types();
hide_greys_names();

function hide_greys_types() {
    for (var i = 0; i <= greys_types.length - 1; i++) {
        greys_types[i].style.display = 'none';
    }
}

function show_greys_types() {
    for (var i = 0; i <= greys_types.length - 1; i++) {
        greys_types[i].style.display = 'block';
    }
}

function hide_greys_names() {
    for (var i = 0; i <= greys_names.length - 1; i++) {
        greys_names[i].style.display = 'none';
    }
}

function show_greys_names() {
    if (showGreyNamesAllowed)
        for (var i = 0; i <= greys_names.length - 1; i++) {
            greys_names[i].style.display = 'block';
        }
}


function checkMassaFormat() {
    var massa = Number(document.getElementById('massa').value);
    document.getElementById('massa').value = massa.toFixed(2);
}


function checkField(){

    isFormFilled = true;
    
    if(document.getElementById("selectTo").value==""){
        document.getElementById("selectTo").style.border = "1px solid #8B0000";
        document.getElementById("selectTo").style.borderRadius = "5px";
        isFormFilled = false;
    } else {
        document.getElementById("selectTo").style.border = "0px";
        document.getElementById("selectTo").style.borderRadius = "0px";
    }
    if(document.getElementById("selectFrom").value==""){
        document.getElementById("selectFrom").style.border = "1px solid #8B0000";
        document.getElementById("selectFrom").style.borderRadius = "5px";
        isFormFilled = false;
    } else {
        document.getElementById("selectFrom").style.border = "0px";
        document.getElementById("selectFrom").style.borderRadius = "0px";

    }
    if(document.getElementById("type_title_send").value==""){
        document.getElementById("selectType").style.border = "1px solid #8B0000";
        document.getElementById("selectType").style.borderRadius = "5px";
        isFormFilled = false;
    } else {
        document.getElementById("selectType").style.border = "0px";
        document.getElementById("selectType").style.borderRadius = "0px";

    }
    if(document.getElementById("selectOperation").value==""){
        document.getElementById("selectOperation").style.border = "1px solid #8B0000";
        document.getElementById("selectOperation").style.borderRadius = "5px";
        isFormFilled = false;
    } else {

        document.getElementById("selectOperation").style.border = "0px";
        document.getElementById("selectOperation").style.borderRadius = "0px";

    }
    if(document.getElementById("name_title_send").value==""){
        document.getElementById("selectName").style.border = "1px solid #8B0000";
        document.getElementById("selectName").style.borderRadius = "5px";
        isFormFilled = false;
    } else {
        document.getElementById("selectName").style.border = "0px";
        document.getElementById("selectName").style.borderRadius = "0px";
    }
    if(document.getElementById("selectStatus_send").value==""){
        document.getElementById("selectStatus").style.border = "1px solid #8B0000";
        document.getElementById("selectStatus").style.borderRadius = "5px";
        isFormFilled = false;
    } else {
        document.getElementById("selectStatus").style.border = "0px";
        document.getElementById("selectStatus").style.borderRadius = "0px";
    }

    if (isFormFilled)
	{
        $('#future').removeAttr('disabled');
	}
        // document.getElementById('future').setAttribute('disabled', 'disabled');
    
}

function selectOnChange(){
    document.getElementById('selectStatus_send').value=document.getElementById('selectStatus').value;
}


function showFun() {
    if(visible) {
        document.getElementById('wrap_types' ).style.display = 'none';
    
        hide_greys_types();

        visible = false;
        arrow.classList.toggle('rotated');
    } else {
        document.getElementById('wrap_types' ).style.display = 'block';
        if(visibleNames) {
            document.getElementById('wrap_names' ).style.display = 'none';
            visibleNames = false;
        }
        
        show_greys_types();
        hide_greys_names();

        if(document.getElementById("dpol").style.display == 'none'){
            hide_greys_types();
            hide_greys_names();
            greys_types[0].style.display = 'block';
        } else {
            show_greys_types();
        }

        visible = true;
        arrow.classList.toggle('rotated');
    }
}

function compareStrings(id1, id2){
    if((document.getElementById(id1).value == document.getElementById(id2).value) && (document.getElementById(id1).value!='') && (document.getElementById(id2).value!='')){
        // console.log(document.getElementById(id1).value);
        // $("#selectName").prop('disabled', 'disabled');
        // $("#selectOperation").prop('disabled', 'disabled');
        // $("#selectType").prop('disabled', 'disabled');
        // document.getElementById("selectType").onclick = function(){};
        // $("#value").prop('disabled', 'disabled');
        // $("#massa").prop('disabled', 'disabled');
    }else{
        
        // $("#selectName").removeAttr("disabled");
        // $("#selectOperation").removeAttr("disabled");
        // $("#selectType").removeAttr("disabled");
        // document.getElementById("selectType").onclick = showFun;
        // $("#value").removeAttr("disabled");
        // $("#massa").removeAttr("disabled");
    }
}

function showNames() {
    if(visibleNames && usingName) {
        document.getElementById('wrap_types' ).style.display = 'none';
        arrowName.classList.toggle('rotated');
        document.getElementById('wrap_names' ).style.display = 'none';

        hide_greys_names();

        visibleNames = false;
    } else if(!visibleNames  && type_selected && usingName){
        arrowName.classList.toggle('rotated');
        document.getElementById('wrap_names' ).style.display = 'block';

        if (visible) {
            document.getElementById('wrap_types' ).style.display = 'none';
            visible = false;
        }
        greys_names[0].style.display = 'block';
        show_greys_names();
        hide_greys_types();

        visibleNames = true;
    }
}

function clock() {
    var d = new Date();
    
    var hours = d.getHours();
    var minutes = d.getMinutes();
    var seconds = d.getSeconds();

    var dd = d.getDate();
    var mm = d.getMonth()+1; //January is 0!
    var yy = d.getFullYear().toString().substr(-2);

    if(dd < 10) {
        dd = '0'+dd
    } 

    if(mm < 10) {
        mm = '0'+mm
    } 

    document.getElementById('date').innerHTML = dd + '.' + mm + '.' + yy;
   
    if (hours <= 9) hours = "0" + hours;
    if (minutes <= 9) minutes = "0" + minutes;
    if (seconds <= 9) seconds = "0" + seconds;

    date_time = hours + ":" + minutes;
    document.getElementById("time").innerHTML = date_time;

    document.getElementById('date_send').value = dd + '.' + mm + '.' + yy;
    document.getElementById('time_send').value = date_time;

    setTimeout("clock()", 1000);
}

function selectType(type, name, desc, src) {

    document.getElementById('type_title_send').value = name;
    document.getElementById('type_desc_send').value = desc;

    $("#img_type").attr("src", "../images/storage/" + src);
    document.getElementById('type_img_name').value = src;

    document.getElementById('type_selected_title').innerText = name;
    document.getElementById('type_selected_desc').innerText = desc;
    
    if(name == "Металл" || name == "Лигатура"){

        document.getElementById('value').value = 0;
        document.getElementById('value').setAttribute('onfocus', 'this.blur()');
        document.getElementById('value').style.color = "#e2e2e2";

        
        //document.getElementById('selectStatus').value = 'null';
        document.getElementById("name_title_send").value = "null";
        
        document.getElementById('selectStatus').style.color = "#CCCCCC";
        $("#selectStatus").prop('disabled', 'disabled');
        document.getElementById('selectStatus_send').value='null';
        
        document.getElementById('nonselected_name').setAttribute('class', '');
        document.getElementById('selected_name').setAttribute('class', 'hidden');

        document.getElementById('selectName').style.color = "#CCCCCC";
        
        document.getElementById("selectName").style.border = "0px solid #fff8ca";
        document.getElementById("selectName").style.borderRadius = "0px";
        
        $("#selectName").prop('disabled', 'disabled');

        selectNameOfType('1', (document.getElementById('type_img_name').value).slice(0,-4));
        
        usingName = false;
    } else {

        $("#value").removeAttr("onfocus");
        document.getElementById('value').style.color = "";
        document.getElementById('selectStatus_send').value=document.getElementById('selectStatus').value;
        document.getElementById("selectStatus").style.border = "0px solid #fff8ca";
        document.getElementById("selectStatus").style.borderRadius = "0px";

        if (document.getElementById('selectFrom').value != "Склад") {
            document.getElementById('selectStatus').style.color = "";
            $("#selectStatus").removeAttr('disabled');
        }
        
        document.getElementById("name_title_send").value = ""; 
        if(testStatus == true){
        //  $("#selectStatus option[value='']").css("display","block");
        //  $("#selectStatus").removeAttr("disabled");
        //  document.getElementById('selectStatus').style.color = "#3d3d3d";
        //document.getElementById('selectStatus_send').value=document.getElementById('selectStatus').value;
        }
        
        usingName = true;
        
        $("#selectName").removeAttr("disabled");
        document.getElementById('selectName').style.color = "#3d3d3d";
    }

    if (name == "Деталь") {
        if (isSelectedName2) {
            document.getElementById('nonselected_name').setAttribute('class', '');
            document.getElementById('selected_name').setAttribute('class', 'hidden');
        } 
        showGreyNamesAllowed = true;
    } else {
        if (!isSelectedName2) {
            document.getElementById('nonselected_name').setAttribute('class', '');
            document.getElementById('selected_name').setAttribute('class', 'hidden');
        } 
        showGreyNamesAllowed = false;
    }
    

    if(document.getElementById('selectFrom').value == 'Склад'){
        document.getElementById('selectStatus_send').value = 'null';
    }
    document.getElementById('wrap_types' ).style.display = 'none';

    hide_greys_types();
    hide_greys_names();

    document.getElementById('nonselected_type').setAttribute('class', 'hidden');
    document.getElementById('selected_type').setAttribute('class', 'select_tp');
    document.getElementById('selected_type').setAttribute('style', 'padding:0');
    visible = false;
    type_selected = true;

    document.getElementById('select_type_in_name').innerText = type;
    document.getElementById('select_title_in_name').innerText = name;
    document.getElementById('select_desc_in_name').innerText = desc;
    if(document.getElementById('select_type_in_name').innerHTML=='Полуфабрикаты'){
        $("#select_img_in_name").attr("src", "../images/storage/pfUnic.jpg");
        $("#img_name").attr("src", "../images/storage/pfUnic.jpg");
    }else if(document.getElementById('select_type_in_name').innerHTML=='Детали'){
        $("#select_img_in_name").attr("src", "../images/storage/dtUnic.jpg");
    }else{
        $("#select_img_in_name").attr("src", "../images/storage/" + src);
    }
    
    generateNames(name, name + "" + desc);
    if(name == "Металл" || name == "Лигатура")
        selectNameOfType('1', (document.getElementById('type_img_name').value).slice(0,-4));
    else resetName();
    
}

function resetName() {
    document.getElementById('nonselected_name').setAttribute('class', '');
    document.getElementById('selected_name').setAttribute('class', 'hidden');

     document.getElementById('name_title_send').value = "";
    document.getElementById('name_desc_send').value = "";
}

function selectNameOfType(number, number_img) {

    if(document.getElementById('select_type_in_name').innerHTML=='Полуфабрикаты'){
        document.getElementById('name_img_name').value = 'pfUnic.jpg';
        $("#img_name").attr("src", "../images/storage/pfUnic.jpg");
    }else if(document.getElementById('select_type_in_name').innerHTML=='Детали'){
        document.getElementById('name_img_name').value = 'dtUnic.jpg';  
        $("#img_name").attr("src", "../images/storage/dtUnic.jpg");
    }else{
        $("#img_name").attr("src", "../images/storage/" + number_img + '.png');
        document.getElementById('name_img_name').value = number_img + '.png';
    }
    
    number--;
    isSelectedName2 = false;
  //  document.getElementById('name_title_send').value = number < 30 ? "Основы" : number < 56 ? "Накладки" : number < 61 ? "Задние части" : "Ножки";
    document.getElementById('name_title_send').value = document.getElementById('select_type_in_name').innerHTML;
    document.getElementById('name_desc_send').value = document.getElementById('select_desc_in_name').innerHTML;
  //  document.getElementById('name_type_send').value = document.getElementById('select_desc_in_name').innerHTML;

  //  document.getElementById('name_selected_title').innerText = number < 30 ? "Основы" : number < 56 ? "Накладки" : number < 61 ? "Задние части" : "Ножки";
    document.getElementById('name_selected_title').innerText = document.getElementById('select_type_in_name').innerHTML;
    document.getElementById('name_selected_desc').innerHTML = document.getElementById('select_desc_in_name').innerHTML;
  //  document.getElementById('name_selected_type').innerHTML = document.getElementById('select_desc_in_name').innerHTML;
    
    document.getElementById('nonselected_name').setAttribute('class', 'hidden');
    document.getElementById('selected_name').setAttribute('class', 'select_nm');
    document.getElementById('selected_name').setAttribute('style', 'padding:0');
    document.getElementById('wrap_names' ).style.display = 'none';
    hide_greys_names();

    type_selected = true;
    visibleNames = false;
}

function selectName(number, number_img) {


    document.getElementById('name_img_name').value = number_img + '.jpg';
    isSelectedName2 = false;

    $("#img_name").attr("src", "../images/storage/" + number_img + '.jpg');
    number--;

    document.getElementById('name_title_send').value = number < 30 ? "Основы" : number < 56 ? "Накладки" : number < 61 ? "Задние части" : "Ножки";
    document.getElementById('name_desc_send').value = names[number];
    document.getElementById('name_type_send').value = document.getElementById('select_title_in_name').innerHTML + " " + document.getElementById('select_desc_in_name').innerHTML;

    document.getElementById('name_selected_title').innerText = number < 30 ? "Основы" : number < 56 ? "Накладки" : number < 61 ? "Задние части" : "Ножки";
    document.getElementById('name_selected_desc').innerHTML = names[number];
    document.getElementById('name_selected_type').innerHTML = document.getElementById('select_title_in_name').innerHTML + " " + document.getElementById('select_desc_in_name').innerHTML;

    document.getElementById('nonselected_name').setAttribute('class', 'hidden');
    document.getElementById('selected_name').setAttribute('class', 'select_nm');
    document.getElementById('selected_name').setAttribute('style', 'padding:0');
    document.getElementById('wrap_names' ).style.display = 'none';
    hide_greys_names();

    type_selected = true;
    visibleNames = false;
}

function selectName2(number) {
    number--;

    document.getElementById('name_title_send').value = '';
    document.getElementById('name_desc_send').value = names2[number];
    document.getElementById('name_type_send').value = document.getElementById('select_title_in_name').innerHTML + " " + document.getElementById('select_desc_in_name').innerHTML;


    document.getElementById('name_img_name').value = "empty.jpg";
    isSelectedName2 = true;
    
    var scr = "../images/storage/polu/"+(number+1)+"p.jpg";
    
    $.ajax({
        url:scr,
        type:'HEAD',
        error:
            function(){
                $("#img_name").attr("src", "../images/storage/empty.jpg");
            },
        success:
            function(){
                $("#img_name").attr("src", "../images/storage/polu/"+(number+1)+"p.jpg");
            }
    });
    
    

    document.getElementById('name_selected_title').style.display = 'none';
    document.getElementById('name_selected_desc').innerHTML = '<h6 style="margin-top:0;margin-bottom:0">' + names2[number] + '</h6>';
    document.getElementById('name_selected_type').innerHTML = document.getElementById('select_title_in_name').innerHTML + " " + document.getElementById('select_desc_in_name').innerHTML;

    document.getElementById('nonselected_name').setAttribute('class', 'hidden');
    document.getElementById('selected_name').setAttribute('class', 'select_nm');
    document.getElementById('selected_name').setAttribute('style', 'padding:0');
    document.getElementById('wrap_names' ).style.display = 'none';
    hide_greys_names();

    type_selected = true;
    visibleNames = false;
}


function generateNames(type, selected_type_title) {

    var type_1 = document.getElementsByName('type_1');
    var type_2 = document.getElementsByName('type_2');

    if (type == "Деталь") {
        var kind_of_name = document.getElementsByName('kind_of_name');
        var name = document.getElementsByName('name');
        var desc = document.getElementsByName('desc');
        var type_of_name = document.getElementsByName('type_of_name');

        for (var i = 0; i < type_2.length; i++) {
            type_2[i].style.display = 'none';
        }
        for (var i = 0; i < type_1.length; i++) {
            type_1[i].style.display = 'block';
        }

        var first_index_count = 30;//30
        var second_index_count = 26;
        var third_index_count = 5;
        var forth_index_count = 7;

        var name = document.getElementsByName('name');

        
        for (var i = 0; i <= first_index_count - 1; i++) {
            kind_of_name[i].innerText = 'Основы';
        }
        for (var i = first_index_count; i <= first_index_count + second_index_count - 1; i++) {
            kind_of_name[i].innerText = 'Накладки';   
        }

        for (var i = first_index_count + second_index_count; i <= third_index_count + first_index_count + second_index_count - 1; i++) {
            kind_of_name[i].innerText = 'Задние части';   
        }

        for (var i = third_index_count + first_index_count + second_index_count; i <= forth_index_count + third_index_count + first_index_count + second_index_count - 1; i++) {
            kind_of_name[i].innerText = 'Ножки';   
        }

        for (var i = 0; i < type_of_name.length; i++) {
            type_of_name[i].innerHTML = selected_type_title;
        }

        for (var i = 0; i < name.length; i++) {
            name[i].innerHTML = names[i];
            
            desc[i].style.display = 'none';
            desc[i].innerHTML = descs[i];
        }
    } else {
        var name = document.getElementsByName('name_2');
        var desc = document.getElementsByName('desc_2');
        var kind_of_name = document.getElementsByName('kind_of_name_2');
        var type_of_name = document.getElementsByName('type_of_name_2');


        var names2 = ['Фантом (задняя часть с малой поворотной ножкой)','Фантом основа с покрытием','Созвездие (основа + задняя часть с малой поворотной ножкой)','Круг малый  (основа + задняя часть с малой поворотной ножкой)','Щит под дерево с орнаментом (основа + ножка)','Круг под дерево с орнаментом (основа + ножка)','Квадрат под дерево с орнаментом (основа + ножка)','Щит под дерево с просветом  (основа + ножка)','Круг под дерево с просветом (основа + ножка)', 'Квадрат под дерево с просветом (основа + ножка)', '8 граней с орнаментом (основа + ножка)', '8 граней с желобом (основа + ножка)', '8 граней под гравировку (основа + ножка)', 'Щит европа стандартный (основа + ножка)','Щит европа с орнаментом (основа + ножка)','Пупырки (основа + ножка)', 'Прямоугольник косичка (основа + ножка)', 'Круг косичка (основа + ножка)', 'Спаси и сохрани с орнаментом (основа + ножка)','Спаси и сохрани под гравировку (основа + ножка)','Спаси и сохрани с надписью (основа + ножка)', 'Премиум квадратный (основа + ножка)','Накладка под премиум квадратный (отполированная)','Премиум круглый (основа + ножка)','Накладка под премиум круглый (отполированная)','Винтажный куб (основа + ножка)','Омниа круг (основа + ножка)','Омниа квадрат (основа + ножка)','Прямоугольник готика под бриллиант (основа + ножка)'];

        
        //29
        for (var i = 0; i < type_1.length; i++) {
            type_1[i].style.display = 'none';
        }
        for (var i = 0; i < type_2.length; i++) {
            type_2[i].style.display = 'block';
        }
        
        for (var i = 0; i <= 3; i++) {
            kind_of_name[i].style.display = 'none';
        }
        
        
        for (var i = 0; i < name.length; i++) {
            name[i].innerHTML = names2[i];
            desc[i].style.display = 'none';
            desc[i].innerHTML = descs[i];
        }
        
        for (var i = 0; i < type_of_name.length; i++) {
            type_of_name[i].innerHTML = selected_type_title;
        }

    }
}

$('#form').submit(function(ev) {
    if (isFormFilled)
        document.getElementById('future').setAttribute('disabled', 'disabled');
});

function checkTo(id1, id2) {

    if(document.getElementById("selectTo").value == "") { 
        document.getElementById("selectFrom").value = "";
        $("#selectFrom option").css("display","block");
        $("#selectTo option").css("display","block");
        $('#selectFrom').removeAttr('onfocus');
        
        $("#selectOperation option").css("display","block");
        document.getElementById('selectOperation').style.color = "#3d3d3d";
        
        document.getElementById('selectFrom').style.color = "";
    }
    else if(document.getElementById("selectTo").value == "Склад") {
        $("#selectFrom option").css("display","block");
        $("#selectFrom option[value='Склад']").css("display","none");

        document.getElementById("selectFrom").value = "";
        
        document.getElementById("selectOperation").value = "Приход";
        // document.getElementById("selectOperation").setAttribute('disabled', 'disabled');
        $("#selectOperation option").css("display","none");
        document.getElementById('selectOperation').style.color = "#CCCCCC";

        document.getElementById('selectFrom').style.color = "";
    } else {

        document.getElementById("selectFrom").value = "Склад";
        // document.getElementById("selectFrom").setAttribute('disabled', 'disabled');
        $("#selectFrom option").css("display","none");

        document.getElementById('selectFrom').style.color = "#CCCCCC";
        $("#selectFrom option[value='Склад']").css("display","none");

        $("#selectFrom option[value='Склад']").css("display","block");
        
        document.getElementById("selectOperation").value = "Расход";
        // document.getElementById("selectOperation").setAttribute('disabled', 'disabled');
        $("#selectOperation option").css("display","none");
        $("#selectOperation option[value='Расход']").css("display","block");
        document.getElementById('selectOperation').style.color = "#CCCCCC";
        
    }

    compareStrings("selectFrom","selectTo");

}

function checkFrom(id1, id2){
    compareStrings("selectFrom","selectTo");

    if((document.getElementById(id1).value=='Склад' && document.getElementById(id2).value=='Приход') || (document.getElementById(id1).value=='Поставщик')){
        document.getElementById("dpol").style.display="none";
        hide_greys_types();
        hide_greys_names();
        greys_types[0].style.display = 'block';
    }else{
        document.getElementById("dpol").style.display="block";
        show_greys_types();
    }

    if(document.getElementById("selectFrom").value == "" && document.getElementById('type_title_send').value == "") { 
    
        
        $("#selectOperation option").css("display","block");
        document.getElementById('selectOperation').style.color = "#3d3d3d";
        
        
        $("#selectStatus").removeAttr("disabled");
        document.getElementById('selectStatus').style.color = "#3d3d3d";
        document.getElementById('selectStatus_send').value=document.getElementById('selectStatus').value;
        
        
        document.getElementById("selectTo").value = "";
        // $('#selectTo').removeAttr('disabled');
        $("#selectTo option").css("display","block");
        $("#selectFrom option").css("display","block");
        document.getElementById('selectTo').style.color = "";
        
        testStatus = false;
    } else if(document.getElementById("selectFrom").value == "Поставщик") {

        
        document.getElementById("selectOperation").value = "Приход";
        $("#selectOperation option").css("display","block");
        document.getElementById('selectOperation').style.color = "#CCCCCC";
        
        $("#selectStatus").removeAttr("disabled");
        document.getElementById('selectStatus').style.color = "#3d3d3d";
        document.getElementById('selectStatus_send').value=document.getElementById('selectStatus').value;
        
        
        $("#selectTo option[value='Склад']").css("display","block");
        document.getElementById("selectOperation").value = "Приход";
        // document.getElementById("selectOperation").setAttribute('disabled', 'disabled');
        $("#selectOperation option").css("display","none");
        document.getElementById('selectOperation').style.color = "#CCCCCC";

        document.getElementById("selectTo").value = "";
        // $('#selectTo').removeAttr('disabled');
        $("#selectTo option").css("display","block");

        document.getElementById('selectTo').style.color = "";

        document.getElementById("selectTo").value = "Склад";
        // document.getElementById("selectTo").setAttribute('disabled', 'disabled');
        $("#selectTo option").css("display","none");
        $("#selectTo option[value='Склад']").css("display","block");
        
        
        document.getElementById('selectTo').style.color = "#CCCCCC";

        testStatus = true;
    } else if(document.getElementById("selectFrom").value == "Склад") {
        
        
        document.getElementById('selectStatus').style.color = "#CCCCCC";
        $("#selectStatus").prop('disabled', 'disabled');
        document.getElementById('selectStatus_send').value='null';
        
        testStatus = false;
        
        document.getElementById("selectOperation").value = "Расход";
        // document.getElementById("selectOperation").setAttribute('disabled', 'disabled');
        $("#selectOperation option").css("display","none");
        $("#selectOperation option[value='Расход']").css("display","block");
        document.getElementById('selectOperation').style.color = "#CCCCCC";

        document.getElementById("selectTo").value = "";
        // $('#selectTo').removeAttr('disabled');
        $("#selectTo option").css("display","block");
        $("#selectTo option[value='Склад']").css("display","none");
        document.getElementById('selectTo').style.color = "";

    } else if (document.getElementById('type_title_send').value == "Металл" || document.getElementById('type_title_send').value == "Лигатура") {
        document.getElementById('selectStatus').style.color = "#CCCCCC";
        $("#selectStatus").prop('disabled', 'disabled');
        document.getElementById('selectStatus_send').value='null';
    } else if (document.getElementById("selectFrom").value != ""){  
        console.log()
        $("#selectStatus").removeAttr("disabled");
        document.getElementById('selectStatus').style.color = "#3d3d3d";
        document.getElementById('selectStatus_send').value=document.getElementById('selectStatus').value;
        
        document.getElementById("selectTo").value = "Склад";
        // document.getElementById("selectTo").setAttribute('disabled', 'disabled');
        $("#selectTo option").css("display","none");
        document.getElementById('selectTo').style.color = "#CCCCCC";

        $("#selectTo option[value='Склад']").css("display","block");
        // $('#selectOperation').removeAttr('disabled');
        if (document.getElementById("selectTo").value != "Склад") {
            $("#selectOperation option").css("display","block");
            document.getElementById('selectOperation').style.color = "";
        }
        document.getElementById("selectOperation").value = "Приход";
        $("#selectOperation option").css("display","block");
        document.getElementById('selectOperation').style.color = "#CCCCCC";
        //testStatus = true;
    }

}