function ValidareFormular() {
       var nume = document.forms["produs"]["nume"].value;
       //validare nume
        var regnume =/^[A-Za-z0-9- ]*$/;
          if(!nume) {
               alert('Nu ati introdus numele. ');
               return false;
          }
            if( nume.length<2 || nume.length>200 || !regnume.test(nume)){
               alert('Numele introdus nu este valid. ');
               return false;
          }
          
        var denumire = document.forms["produs"]["denumire"].value;
       //validare denumire
        var regdenumire =/^[A-Za-z0-9- ]*$/;
          if(!denumire) {
               alert('Nu ati introdus denumirea produsului. ');
               return false;
          }
            if( denumire.length<2 || denumire.length>200 || !regdenumire.test(denumire)){
               alert('Denumirea introdusa nu este valida. ');
               return false;
          }
          
        var brand = document.forms["produs"]["brand"].value;
       //validare denumire
        var regbrand =/^[A-Za-z0-9- ]*$/;
          if(!brand) {
              alert('Nu ati introdus brandul produsului. ');
               return false;
          }
            if( brand.length<2 || brand.length>200 || !regbrand.test(brand)){
               alert('Brandul introdus nu este valid. ');
               return false;
          }
          
        var descriere = document.forms["produs"]["descriere"].value;
       //validare denumire
       
          if(!descriere) {
              alert('Nu ati introdus descrierea produsului. ');
               return false;
          }
            if( descriere.length<2 || descriere.length>200){
               alert('Descrierea introdusa nu este valida. ');
               return false;
          }
          
          var pret = document.forms["produs"]["pret"].value;
          if(!pret) {
              alert('Nu ati introdus pretul produsului. ');
               return false;
          }
            if(isNaN(pret)){
               alert('Pretul introdus nu este valid. ');
               return false;
          }
          
          var pretspecial = document.forms["produs"]["pretspecial"].value;
          if(!pretspecial) {
              alert('Nu ati introdus pretul special al produsului. ');
               return false;
          }
            if(isNaN(pretspecial)){
               alert('Pretul special introdus nu este valid. ');
               return false;
          }
          
           var stoc = document.forms["produs"]["stoc"].value;
          if(!stoc) {
              alert('Nu ati introdus stocul produsului. ');
               return false;
          }
            if(isNaN(stoc)){
               alert('Stocul introdus nu este valid. ');
               return false;
          }
       
            return true;
  
}