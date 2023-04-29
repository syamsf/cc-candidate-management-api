@include('layout/header')

<body class="hold-transition sidebar-mini">
<div class="wrapper">
  @include('layout/top-navbar')

  @include('layout/left-sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

  <div class="modal fade" id="candidate-add">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <h4 class="modal-title">Add Candidate</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="create-form" method="post">

        <div class="modal-body">
          <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" id="email-create" name="email"></input>
            <span id="email-error" class="error text-danger"></span>
          </div>
          <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" id="name-create" name="name"></input>
            <span id="name-error" class="error text-danger"></span>
          </div>
          <div class="form-group">
            <label>Birthdate</label>
            <input type="text" class="form-control" id="birthdate-create" name="birthdate" placeholder="2023-01-01"></input>
            <span id="birthdate-error" class="error text-danger"></span>
          </div>
          <div class="form-group">
            <label>Education</label>
            <input type="text" class="form-control" id="education-create" name="education"></input>
            <span id="education-error" class="error text-danger"></span>
          </div>
          <div class="form-group">
            <label>Experience</label>
            <input type="text" class="form-control" id="experience-create" name="experience"></input>
          </div>
          <div class="form-group">
            <label>Last Position</label>
            <input type="text" class="form-control" id="lastposition-create" name="last_position"></input>
          </div>
          <div class="form-group">
            <label>Applied Position</label>
            <input type="text" class="form-control" id="applied_position-create" name="applied_position"></input>
            <span id="applied_position-error" class="error text-danger"></span>
          </div>
          <div class="form-group">
            <label>Phone</label>
            <input type="text" class="form-control" id="phone-create" name="phone" placeholder="0812345678"></input>
            <span id="phone-error" class="error text-danger"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputFile">Resume</label>
            <div class="input-group">
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="resume-create" name="resume">
                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
              </div>
            </div>
            <span id="resume-error" class="error text-danger"></span>
          </div>
          <div class="form-group">
            <label>Top Five Skills</label>
            <input type="text" class="form-control" id="topfiveskills-create" required name="top_five_skills" placeholder="skill 1, skill 2, skill 3, skill 4, skill 5"></input>
            <span id="top_five_skills-error" class="error text-danger"></span>
          </div>
        </div>

        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="btn-create">Save changes</button>
        </div>

        </form>

      </div>
    </div>
  </div>

  <div class="modal fade" id="candidate-update">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Candidate Update</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="update-form" method="post">

        <input type="hidden" id="candidate-id-update"></input>

        <div class="modal-body">
          <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" id="email-update" name="email"></input>
            <span id="email-update-error" class="error text-danger"></span>
          </div>
          <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" id="name-update" name="name"></input>
            <span id="name-update-error" class="error text-danger"></span>
          </div>
          <div class="form-group">
            <label>Birthdate</label>
            <input type="text" class="form-control" id="birthdate-update" name="birthdate"></input>
            <span id="birthdate-update-error" class="error text-danger"></span>
          </div>
          <div class="form-group">
            <label>Education</label>
            <input type="text" class="form-control" id="education-update" name="education"></input>
            <span id="education-update-error" class="error text-danger"></span>
          </div>
          <div class="form-group">
            <label>Experience</label>
            <input type="text" class="form-control" id="experience-update" name="experience"></input>
            <span id="experience-update-error" class="error text-danger"></span>
          </div>
          <div class="form-group">
            <label>Last Position</label>
            <input type="text" class="form-control" id="lastposition-update" name="last_position"></input>
            <span id="lastposition-update-error" class="error text-danger"></span>
          </div>
          <div class="form-group">
            <label>Applied Position</label>
            <input type="text" class="form-control" id="appliedposition-update" name="applied_position"></input>
            <span id="appliedposition-update-error" class="error text-danger"></span>
          </div>
          <div class="form-group">
            <label>Phone</label>
            <input type="text" class="form-control" id="phone-update" name="phone"></input>
            <span id="phone-update-error" class="error text-danger"></span>
          </div>
          <div class="form-group">
            <label>Resume</label>
            <input type="text" class="form-control" id="resume-update" disabled></input>
          </div>
          <div class="form-group">
            <label>Top Five Skills</label>
            <input type="text" class="form-control" id="topfiveskills-update" name="top_five_skills"></input>
            <span id="topfiveskills-update-error" class="error text-danger"></span>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="btn-update">Save changes</button>
        </div>

        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="candidate-detail">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Candidate Detail</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" id="email-view" value="" disabled></input>
          </div>
          <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" id="name-view" value="" disabled></input>
          </div>
          <div class="form-group">
            <label>Birthdate</label>
            <input type="text" class="form-control" id="birthdate-view" value="" disabled></input>
          </div>
          <div class="form-group">
            <label>Education</label>
            <input type="text" class="form-control" id="education-view" value="" disabled></input>
          </div>
          <div class="form-group">
            <label>Experience</label>
            <input type="text" class="form-control" id="experience-view" value="" disabled></input>
          </div>
          <div class="form-group">
            <label>Last Position</label>
            <input type="text" class="form-control" id="lastposition-view" value="" disabled></input>
          </div>
          <div class="form-group">
            <label>Applied Position</label>
            <input type="text" class="form-control" id="applied_position-view" value="" disabled></input>
          </div>
          <div class="form-group">
            <label>Phone</label>
            <input type="text" class="form-control" id="phone-view" value="" disabled></input>
          </div>
          <div class="form-group">
            <label>Resume</label>
            <input type="text" class="form-control" id="resume-view" value="" disabled></input>
          </div>
          <div class="form-group">
            <label>Top Five Skills</label>
            <input type="text" class="form-control" id="topfiveskills-view" value="" disabled></input>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Candidate Management</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Candidate Management</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col">
                      <div class="row">
                        <h3 class="card-title">Candidate Data</h3>
                      </div>
                    </div>
                    <div class="col">
                      <div class="row justify-content-end">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#candidate-add">Add Candidate</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Applied Position</th>
                      <th>Birthdate</th>
                      <th>Education</th>
                      <th>Experience</th>
                      <th>Last position</th>
                      <th>Phone</th>
                      <th>Resume</th>
                      <th>Top Five Skills</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Applied Position</th>
                      <th>Birthdate</th>
                      <th>Education</th>
                      <th>Experience</th>
                      <th>Last position</th>
                      <th>Phone</th>
                      <th>Resume</th>
                      <th>Top Five Skills</th>
                      <th>Action</th>
                    </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@include('layout/footer')

@include('layout/required-script')

<script>
  const candidatesList = async () => {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: "http://localhost:8001/api/v1/candidates",
        headers: {
          'Authorization': "Bearer {{ session()->get('access_token') }}"
        },
        type: "GET",
        dataType: "json",
        success: function(data) {
          resolve(data['data'])
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.error(textStatus, errorThrown)
          reject(errorThrown)
        }
      })
    })
  }

  const candidateData = async (id) => {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `http://localhost:8001/api/v1/candidates/${id}`,
        headers: {
          'Authorization': "Bearer {{ session()->get('access_token') }}"
        },
        type: "GET",
        dataType: "json",
        success: function(data) {
          resolve(data['data'])
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.error(textStatus, errorThrown)
          reject(errorThrown)
        }
      })
    })
  }

  const populateDataTable = () => {
    candidatesList()
    .then(data => {
      $("#example1").DataTable({
        "data": data,
        "columns": [
          {
            "data": null, "title": "#",
            "render": function ( data, type, row, meta ) {
              return meta.row + 1;
            }
          },
          {
            "data": "name", "title": "Name", "createdCell": function (td, cellData, rowData, rowIndex, colIndex) {
              $(td).attr('data-custom', 'name-' + rowIndex);
            }
          },
          {
            "data": "applied_position", "title": "Applied Position", "createdCell": function (td, cellData, rowData, rowIndex, colIndex) {
              $(td).attr('data-custom', 'name-' + rowIndex);
            }
          },
          {
            "data": "email", "title": "Email", "createdCell": function (td, cellData, rowData, rowIndex, colIndex) {
              $(td).attr('data-custom', 'name-' + rowIndex);
            }
          },
          {
            "data": "birthdate", "title": "Birthdate", "createdCell": function (td, cellData, rowData, rowIndex, colIndex) {
              $(td).attr('data-custom', 'name-' + rowIndex);
            }
          },
          {
            "data": "education", "title": "Education", "createdCell": function (td, cellData, rowData, rowIndex, colIndex) {
              $(td).attr('data-custom', 'name-' + rowIndex);
            }
          },
          {
            "data": "experience", "title": "Experience", "createdCell": function (td, cellData, rowData, rowIndex, colIndex) {
              $(td).attr('data-custom', 'name-' + rowIndex);
            }
          },
          {
            "data": "last_position", "title": "Last position", "createdCell": function (td, cellData, rowData, rowIndex, colIndex) {
              $(td).attr('data-custom', 'name-' + rowIndex);
            }
          },
          {
            "data": "phone", "title": "Phone", "createdCell": function (td, cellData, rowData, rowIndex, colIndex) {
              $(td).attr('data-custom', 'name-' + rowIndex);
            }
          },
          {
            "data": "resume", "title": "Resume", "render": function ( data, type, row ) {
              return `<a href="${data}" target="_blank">${data}</a>`
            }
          },
          {
            "data": "top_five_skills", "title": "Top Five Skills", "createdCell": function (td, cellData, rowData, rowIndex, colIndex) {
              $(td).attr('data-custom', 'name-' + rowIndex);
            }
          },
          {
            "data": "id", "title": "Action", "render": function ( data, type, row ) {
              return `
                <button class="btn btn-info" data-toggle="modal" data-target="#candidate-detail" data-value="${data}">View</button>
                @php
                  $isScopeValid = session()->has('scope') && in_array('manage-candidate', session()->get('scope'));
                @endphp
                @if ($isScopeValid)
                  <button class="btn btn-primary" data-toggle="modal" data-target="#candidate-update" data-value="${data}">Edit</button>
                  <button class="btn btn-danger" onclick="deleteItem('${data}')">Delete</button>
                @endif
              `;
            }
          },
        ],
        "responsive": true, "lengthChange": true, "autoWidth": false,
        "buttons": ["colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)')
    }).catch(error => {
      console.error(error);
    });
  }

  populateDataTable()

  $('#candidate-detail').on('show.bs.modal', function (event) {
    const button = $(event.relatedTarget)
    const value = button.data('value')
    const modal = $(this)

    candidateData(value).then(data => {
      $('#email-view').val(data.email)
      $('#name-view').val(data.name)
      $('#birthdate-view').val(data.birthdate)
      $('#education-view').val(data.education)
      $('#experience-view').val(data.experience)
      $('#lastposition-view').val(data.last_position)
      $('#applied_position-view').val(data.applied_position)
      $('#phone-view').val(data.phone)
      $('#resume-view').val(data.resume)
      $('#topfiveskills-view').val(data.top_five_skills)
    })
  })

  $('#candidate-update').on('show.bs.modal', function (event) {
    const button = $(event.relatedTarget)
    const value = button.data('value')
    const modal = $(this)

    candidateData(value).then(data => {
      $('#email-update').val(data.email)
      $('#name-update').val(data.name)
      $('#birthdate-update').val(data.birthdate)
      $('#education-update').val(data.education)
      $('#experience-update').val(data.experience)
      $('#lastposition-update').val(data.last_position)
      $('#appliedposition-update').val(data.applied_position)
      $('#phone-update').val(data.phone)
      $('#resume-update').val(data.resume)
      $('#topfiveskills-update').val(data.top_five_skills)
      $('#candidate-id-update').val(data.id)
    })
  })

  function deleteItem(itemId) {
    Swal.fire({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover this item!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    })
    .then((willDelete) => {
      if (willDelete.isConfirmed) {
          $.ajax({
            url: 'http://localhost:8001/api/v1/candidates/' + itemId,
            headers: {
              'Authorization': "Bearer {{ session()->get('access_token') }}"
            },
            method: 'DELETE',
            success: function(response) {
              Swal.fire({title: "Item deleted!", icon: "success",});
              $('#example1').DataTable().destroy()
              populateDataTable()
            },
            error: function(xhr, status, error) {
              Swal.fire("Oops!", "Something went wrong: " + error, "error");
            }
          });
        }
    })
  }

  $('#create-form').submit(function(e) {
    e.preventDefault();

    const formData = new FormData($('#create-form')[0])

    const topFiveSkills = formData.get('top_five_skills').split(',');
    formData.delete('top_five_skills');
    for (let i = 0; i < topFiveSkills.length; i++) {
      formData.append('top_five_skills[]', topFiveSkills[i]);
    }

    const birthdate = new Date(formData.get('birthdate')).toISOString().split('T')[0]
    formData.delete('birthdate');
    formData.append('birthdate', birthdate);

    $.post({
        url: "{{ route('create') }}",
        headers: {
          'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
          if (response.success) {
            $('#candidate-add').modal('hide');
            Swal.fire({title: "Candidate successfully added", icon: "success",});

            $('#example1').DataTable().destroy()
            populateDataTable()
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          const response = jqXHR.responseJSON;

          $('#email-error').text(response.errors.email ? response.errors.email[0] : '');
          $('#name-error').text(response.errors.name ? response.errors.name[0] : '');
          $('#education-error').text(response.errors.education ? response.errors.education[0] : '');
          $('#birthdate-error').text(response.errors.birthdate ? response.errors.birthdate[0] : '');
          $('#phone-error').text(response.errors.phone ? response.errors.phone[0] : '');
          $('#resume-error').text(response.errors.resume ? response.errors.resume[0] : '');
          $('#top_five_skills-error').text(response.errors.top_five_skills ? response.errors.top_five_skills[0] : '');
          $('#applied_position-error').text(response.errors.applied_position ? response.errors.applied_position[0] : '');
        }
    });
  });

  $('#btn-create').click(function() {
    $('#create-form').submit();
  });

  $('#update-form').submit(function(e) {
    e.preventDefault();

    const formData = new FormData($('#update-form')[0])

    const topFiveSkills = formData.get('top_five_skills').split(',');
    formData.delete('top_five_skills');
    for (let i = 0; i < topFiveSkills.length; i++) {
      formData.append('top_five_skills[]', topFiveSkills[i]);
    }

    const birthdate = new Date(formData.get('birthdate')).toISOString().split('T')[0]
    formData.delete('birthdate');
    formData.append('birthdate', birthdate);

    const candidateId = $('#candidate-id-update').val() ?? 0

    $.post({
        url: "{{ route('update', ':id') }}".replace(':id', candidateId),
        headers: {
          'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
          if (response.success) {
            $('#candidate-update').modal('hide');
            Swal.fire({title: "Candidate successfully updated", icon: "success",});

            $('#example1').DataTable().destroy()
            populateDataTable()
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          const response = jqXHR.responseJSON

          console.log(response)

          $('#email-update-error').text(response.errors.email ? response.errors.email[0] : '');
          $('#name-update-error').text(response.errors.name ? response.errors.name[0] : '');
          $('#education-update-error').text(response.errors.education ? response.errors.education[0] : '');
          $('#birthdate-update-error').text(response.errors.birthdate ? response.errors.birthdate[0] : '');
          $('#phone-update-error').text(response.errors.phone ? response.errors.phone[0] : '');
          $('#topfiveskills-update-error').text(response.errors.top_five_skills ? response.errors.top_five_skills[0] : '');
          $('#appliedposition-update-error').text(response.errors.applied_position ? response.errors.applied_position[0] : '');
        }
    });
  });

  $('#btn-update').click(function() {
    $('#update-form').submit();
  });

</script>
</body>
</html>
