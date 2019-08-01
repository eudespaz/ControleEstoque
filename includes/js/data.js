
   function mascaraData(campoData)
   {
              var data = campoData.value;
              if (data.length == 2)
              {
                  data = data + '/';
                  document.forms[0].data.value = data;
				      return true;              
              }
              if (data.length == 5)
              {
                  data = data + '/';
                  document.forms[0].data.value = data;
                  return true;
	         	}
	 }
	    function mascaraData2(campoData)
   {
              var data = campoData.value;
              if (data.length == 2)
              {
                  data = data + '/';
                  document.forms[0].data2.value = data;
				      return true;              
              }
              if (data.length == 5)
              {
                  data = data + '/';
                  document.forms[0].data2.value = data;
                  return true;
	         	}
	 }
	 
