function displayData(dataFromTable)
{
    var dataTable =  $('#dataTable').dataTable({
        columnDefs: [{
                "defaultContent": "-",
                "targets": "_all"
                 }],
        columns: [
                { 'data': 'firstName' },
                { 'data': 'lastName' },
                { 'data': 'phone' },
                { 'data': 'email' },
               ],
        data: dataFromTable, // Populates with data from table
        "bLengthChange": false, // Hides changing # of entries shown
        "sDom": 'lrtip', // Hides default search box
        "bInfo": false }); // Hides # of entries currently shown
      
      // Allows for clicking on rows
      var dataTable = $('#dataTable').dataTable();
      var DataTable = $('#dataTable').DataTable();
      DataTable.on('click', 'tbody tr', function() {
        console.log('API row values : ', DataTable.row(this).data());
        var idNum = DataTable.row(this).data().ID;
      })
      // Allows for use of our own search input field
      $("#searchContact").keyup(function() {
          dataTable.fnFilter(this.value);
      });
}