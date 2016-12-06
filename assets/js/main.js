
$(document).ready(function(){
  $('#history_table').DataTable({
      "order": [[ 6, "desc"]]
  });  
    $('#outstanding_table').DataTable({
      "order": [[ 6, "desc"]],
      "pagination": false
  });
  

        
})

var data = JSON.parse(document.getElementById('dom-target').innerHTML);
data = 
console.log(data);
new Morris.Line({
  element: 'myfirstchart',
  data: [ data ],
      xkey: 'time',
      ykeys: ['value'],
      labels: ['value']
});

