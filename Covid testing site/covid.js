


let selection = document.querySelector('select');
let result = document.querySelector('h2');

var url = "https://sheetlabs.com/NCOR/covidtestcentersinUS?state="

selection.addEventListener('change',() => {
result.innerText= selection.options[selection.selectedIndex].text;
console.log(selection.selectedIndex);
var requesturl = url +result.innerText;

console.log (url + result.innerText);



var settings = {
  
  "url": "https://sheetlabs.com/NCOR/covidtestcentersinUS?state="+result.innerText,
  "method": "GET",
  "timeout": 0,
};
function Geeks() {
  $(table).remove();
  $(innerText).text
      ("All rows of the table are deleted.");
}
$.ajax(settings).done(function (response) {
 
  console.log(response[1].centername);
  

var div = document.createElement("div");
//var mainContainer = document.getElementById("myData");
var table = document.getElementById('myTable')
//$(table).remove();
table.innerHTML = "";
for (var i = 0; i < response.length; i++) {
  response[i].centername;

  
for (var i = 0; i < response.length; i++){
  
  var row = `<tr>
          <td>${response[i].centername}</td>
          <th>        </th>
          <td>${response[i].address}</td>
          <th>        </th>
          <td>${response[i].state}</td>
          <td>         </td>
          <td> <a href= ${response[i].url} >Website </a> </td>
        </tr>`
  table.innerHTML += row


}

}
});

});