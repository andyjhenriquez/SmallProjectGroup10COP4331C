function displayData(dataFromTable)
{
    var dataTable =  $('#dataTable').dataTable({
        columns: [
                {
                field: 'firstName',
                title: 'First Name',
                sortable: true,
                cellStyle: 'cellStyle',
                align: 'center'
              }, {
                field: 'lastName',
                title: 'Last Name',
                sortable: true,
                cellStyle: 'cellStyle',
                align: 'center'
              }, {
                field: 'phone',
                title: 'Phone',
                sortable: "True",
                cellStyle: 'cellStyle',
                align: 'center',
                
              },{
                field: 'email',
                title: 'Email',
                sortable: "True",
                cellStyle: 'cellStyle' ,
                align: 'center'
              }
               ],
        data: dataFromTable, // Populates with data from table
        "bLengthChange": false, // Hides changing # of entries shown
        "sDom": 'lrtip', // Hides default search box
        "bInfo": false }); // Hides # of entries currently shown
      
      // Allows for use of our own search input field
      var dataTable = $('#dataTable').dataTable();
      $("#searchContact").keyup(function() {
          dataTable.fnFilter(this.value);
      });
}