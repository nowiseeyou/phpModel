### Jq ###

#### JS获取表单所有数据 ####
	
	<script type="text/javascript"> 
	  
	//获取指定form中的所有的<input>对象  
	function getElements(formId) {  
	  var form = document.getElementById(formId);  
	  var elements = new Array();  
	  var tagElements = form.getElementsByTagName('input');  
	  for (var j = 0; j < tagElements.length; j++){ 
	     elements.push(tagElements[j]); 
	  
	  } 
	  return elements;  
	}  
	  
	//获取单个input中的【name,value】数组 
	function inputSelector(element) {  
	 if (element.checked)  
	   return [element.name, element.value];  
	}  
	    
	function input(element) {  
	  switch (element.type.toLowerCase()) {  
	   case 'submit':  
	   case 'hidden':  
	   case 'password':  
	   case 'text':  
	    return [element.name, element.value];  
	   case 'checkbox':  
	   case 'radio':  
	    return inputSelector(element);  
	  }  
	  return false;  
	}  
	  
	//组合URL 
	function serializeElement(element) {  
	  var method = element.tagName.toLowerCase();  
	  var parameter = input(element);  
	   
	  if (parameter) {  
	   var key = encodeURIComponent(parameter[0]);  
	   if (key.length == 0) return;  
	   
	   if (parameter[1].constructor != Array)  
	    parameter[1] = [parameter[1]];  
	      
	   var values = parameter[1];  
	   var results = [];  
	   for (var i=0; i<values.length; i++) {  
	    results.push(key + '=' + encodeURIComponent(values[i]));  
	   }  
	   return results.join('&');  
	  }  
	 }  
	  
	//调用方法   
	function serializeForm(formId) {  
	  var elements = getElements(formId);  
	  var queryComponents = new Array();  
	   
	  for (var i = 0; i < elements.length; i++) {  
	   var queryComponent = serializeElement(elements[i]);  
	   if (queryComponent)  
	    queryComponents.push(queryComponent);  
	  }  
	   
	  return queryComponents.join('&'); 
	}  
	  
	</script>


#列表切换#

    $('.change_ul').click(function () {
        $(".service-container li").hide()
        getRandom()
    });

    function getRandom(){
        var arr = [];
        for(var i=0;i<5;i++){
           var random = Math.floor(Math.random()*22)
           if(arr.indexOf(random) !== -1){
               i--;
           }else{
            arr.push(random)
            $(".service-container li").eq(random).show()
           }
        }
    }

#回到顶部#

    // 回到顶部
    $('#goToTop').click(function(){ $('html , body').animate({scrollTop: 0},'slow'); });
