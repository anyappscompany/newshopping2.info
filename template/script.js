function start_search(){

var search_input = document.getElementById("search-input");

var h1_row = document.getElementById("h-title-row");
var content_row = document.getElementById("content-row");
var pagination_row = document.getElementById("pagination-row");
var loader_row = document.getElementById("loader-row");
var content = document.getElementById("content");
                                                  //alert(encodeURIComponent(strip_html_tags(search_input.value).substr(0, 255)));
if(search_input.value.length<3)return;

if(h1_row!=null){
    //h1_row.style.display="none";
}
if(content_row!=null){
    //content_row.style.display="none";
}
if(pagination_row!=null){
    //pagination_row.style.display="none";
}

loader_row.style.display = "block";
/***********************************/
var req = getXmlHttp();
req.onreadystatechange = function() {
    if (req.readyState == 4) {
        if(req.status == 200) {
            if(req.responseText==''){
                    //h1_row.style.display="block";
                    //content_row.style.display="block";
                    //pagination_row.style.display="block";

                    loader_row.style.display = "none";
                    alert("notfound");
                }else{
                    //alert(req.responseText);
                    window.location.href = "http://"+document.domain+"/" + decodeURIComponent(req.responseText);
                }
			}
		}
	}
	req.open('GET', '/search.php?q=' + encodeURIComponent(strip_html_tags(search_input.value).substr(0, 128)), true);
	req.send(null);
}

function getXmlHttp(){
  var xmlhttp;
  try {
    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
  } catch (e) {
    try {
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (E) {
      xmlhttp = false;
    }
  }
  if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
    xmlhttp = new XMLHttpRequest();
  }
  return xmlhttp;
}
function imageerrorloading(image){
    image.src="/template/images/picture-not-available.jpg";
}

function modal_init(url, name){
    var full_view = document.getElementById("full-view");
    var modal_title = document.getElementById("modal-title");
    var modal_body = document.getElementById("modal-body");

    var download_link = document.getElementById("modal-download-link");
    //var str_download = download_cont.innerHTML;
    download_link.setAttribute('href', "http://"+window.location.hostname+"/download.php?file="+url);
    //download_cont.innerHTML = '<a class="btn btn-primary" href="http://'+window.location.hostname+'/download.php?file='+url+'">[DOWNLOAD-PHOTO]</a>';// "http://"+window.location.hostname+"/download.php?file="+url);

    full_view.style.display = "block";

    modal_title.innerText = name;
    modal_body.innerHTML = "<p><img onerror='imageerrorloading(this)' src='"+url+"' /></p>";
}

function load_more_goods(cache_id, goods_limit, page_num, but){
    // (1) создать объект для запроса к серверу
	var req2 = getXmlHttp();

        // (2)
	// span рядом с кнопкой
	// в нем будем отображать ход выполнения
	//var statusElem = document.getElementById('vote_status')

	req2.onreadystatechange = function() {
        // onreadystatechange активируется при получении ответа сервера

		if (req2.readyState == 4) {
            // если запрос закончил выполняться

			//statusElem.innerHTML = req2.statusText // показать статус (Not Found, ОК..)

			if(req2.status == 200) {
                 // если статус 200 (ОК) - выдать ответ пользователю
            var content = document.getElementById("content");
				//alert("Ответ сервера: "+req2.responseText);
                if(req2.responseText.length>0){
                content.innerHTML=req2.responseText;

                var elements = document.getElementsByClassName("pag-nav");
                for (var i=0; i<elements.length; i++){
                    elements[i].classList.remove("active");
                    //console.log("clear " + i);
                }

                but.className = "active pag-nav page-item";

                window.scrollTo(0, 0);
            }
			}
			// тут можно добавить else с обработкой ошибок запроса
		}

	}

       // (3) задать адрес подключения
	req2.open('GET', '/load_more_goods.php?cache_id='+cache_id+'&goods_limit='+goods_limit+'&page_num='+page_num, true);

	// объект запроса подготовлен: указан адрес и создана функция onreadystatechange
	// для обработки ответа сервера

        // (4)
	req2.send(null);  // отослать запрос

        // (5)
	//statusElem.innerHTML = 'Ожидаю ответа сервера...'
}

function addmessage(){
// (1) создать объект для запроса к серверу
	var req3 = getXmlHttp();
    var username = document.getElementById("username").value;
    var useremail = document.getElementById("useremail").value;
    var usermessage = document.getElementById("usermessage").value;


        // (2)
	// span рядом с кнопкой
	// в нем будем отображать ход выполнения
	//var statusElem = document.getElementById('vote_status')

	req3.onreadystatechange = function() {
        // onreadystatechange активируется при получении ответа сервера

		if (req3.readyState == 4) {
            // если запрос закончил выполняться

			//statusElem.innerHTML = req2.statusText // показать статус (Not Found, ОК..)

			if(req3.status == 200) {
                 // если статус 200 (ОК) - выдать ответ пользователю
            //var content = document.getElementById("content");
				//alert("Ответ сервера: "+req2.responseText);
                //if(req3.responseText.length>0){
                //content.innerHTML=req3.responseText;

                alert(req3.responseText);
                /*if(req3.responseText == "ok"){
                    alert("Thank you! Your message has been sent successfully.");
                }else{
                    alert("This message failed to send. Click to send again.");
                }*/
            }
			}
			// тут можно добавить else с обработкой ошибок запроса
		}



       // (3) задать адрес подключения
	req3.open('POST', '/addmessage.php', true);
    req3.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	// объект запроса подготовлен: указан адрес и создана функция onreadystatechange
	// для обработки ответа сервера
    var params = 'username='+encodeURIComponent(username)+'&useremail='+encodeURIComponent(useremail)+'&usermessage='+encodeURIComponent(usermessage);
        // (4)
	req3.send(params);  // отослать запрос

        // (5)
	//statusElem.innerHTML = 'Ожидаю ответа сервера...'
}

function strip_html_tags(str11)
{
var div = document.createElement("div");
div.innerHTML = str11;
var text = div.textContent || div.innerText || "";
return text;
}

function toogle_hearth_class(iobj, login1, shop, user, url, itid){
    if(login1==false){  //alert("11");
        window.location.href = "http://"+document.domain+"/authorization.php?mode=auth";
    }else{
    if(iobj.style.color == "lightgray"){
    //alert(iobj.style.color);
        add_fav(shop, user, url, 1, itid);
        iobj.style.color = "goldenrod ";
    }else{
        add_fav(shop, user, url, 0, itid);
        iobj.style.color = "lightgray";
    }
    }
}

function add_fav(shop, user, url, act, itid){
    // (1) создать объект для запроса к серверу
	var req = getXmlHttp();

        // (2)
	// span рядом с кнопкой
	// в нем будем отображать ход выполнения
	//var statusElem = document.getElementById('vote_status')

	req.onreadystatechange = function() {
        // onreadystatechange активируется при получении ответа сервера

		if (req.readyState == 4) {
            // если запрос закончил выполняться

			//statusElem.innerHTML = req.statusText // показать статус (Not Found, ОК..)

			if(req.status == 200) {
                 // если статус 200 (ОК) - выдать ответ пользователю
				//alert("Ответ сервера: "+req.responseText);
			}
			// тут можно добавить else с обработкой ошибок запроса
		}

	}

       // (3) задать адрес подключения
	req.open('GET', '/favorites.php?act=' + act + "&shop=" + shop + "&user=" + user + "&url=" + url + "&itid="+itid, true);

	// объект запроса подготовлен: указан адрес и создана функция onreadystatechange
	// для обработки ответа сервера

        // (4)
	req.send(null);  // отослать запрос

        // (5)
	//statusElem.innerHTML = 'Ожидаю ответа сервера...'
}

function addlike(act, shop, url, itid){
    // (1) создать объект для запроса к серверу
    alert("Thank you for your vote!");
	var req = getXmlHttp();

        // (2)
	// span рядом с кнопкой
	// в нем будем отображать ход выполнения
	//var statusElem = document.getElementById('vote_status')

	req.onreadystatechange = function() {
        // onreadystatechange активируется при получении ответа сервера

		if (req.readyState == 4) {
            // если запрос закончил выполняться

			//statusElem.innerHTML = req.statusText // показать статус (Not Found, ОК..)

			if(req.status == 200) {
                 // если статус 200 (ОК) - выдать ответ пользователю
				//alert("Ответ сервера: "+req.responseText);

			}
			// тут можно добавить else с обработкой ошибок запроса
		}

	}

       // (3) задать адрес подключения
	req.open('GET', '/addlike.php?act=' + act + "&shop=" + shop + "&url=" + url + "&itid="+itid, true);

	// объект запроса подготовлен: указан адрес и создана функция onreadystatechange
	// для обработки ответа сервера

        // (4)
	req.send(null);  // отослать запрос

        // (5)
	//statusElem.innerHTML = 'Ожидаю ответа сервера...'
}