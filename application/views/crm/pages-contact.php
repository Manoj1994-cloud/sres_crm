
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Contact</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item">Pages</li>
        <li class="breadcrumb-item active">Contact</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section contact">
    <ul class="nav nav-tabs" id="contactTab" role="tablist">
      <li class="nav-item" role="presentation">
        <a class="nav-link active" id="add-contact-tab" data-bs-toggle="tab" href="#add-contact" role="tab" aria-controls="add-contact" aria-selected="true">Add Contact</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" id="view-contacts-tab" data-bs-toggle="tab" href="#view-contacts" role="tab" aria-controls="view-contacts" aria-selected="false">View Contacts</a>
      </li>
    </ul>
    <div class="tab-content" id="contactTabContent">
      <div class="tab-pane fade show active" id="add-contact" role="tabpanel" aria-labelledby="add-contact-tab">
        <div class="col-xl-12 mt-4">
          <div class="card p-4">
            <form id="contactForm" class="php-email-form">
              <div class="row gy-4">

                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                </div>

                <div class="col-md-6">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                </div>

                <div class="col-md-12">
                  <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
                </div>

                <div class="col-md-12">
                  <textarea class="form-control" name="message" id="message" rows="6" placeholder="Message" required></textarea>
                </div>

                <div class="col-md-12 text-center">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Your message has been sent. Thank you!</div>

                  <button type="submit">Send Message</button>
                </div>

              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="view-contacts" role="tabpanel" aria-labelledby="view-contacts-tab">
        <div class="card p-4 mt-4">
          <h5 class="card-title">Contact Submissions</h5>
          <table id="contactTable" class="table table-striped">
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <!-- Data will be populated by JavaScript -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</main><!-- End #main -->

<script>
$(document).ready(function() {
    // Function to fetch and display data
    function fetchContacts() {
        $.ajax({
            url: "<?php echo base_url('index.php/ContactController/getContacts'); ?>",
            method: "GET",
            dataType: "json",
            success: function(data) {
                var tableBody = $('#contactTable tbody');
                tableBody.empty();
                $.each(data, function(index, contact) {
                    tableBody.append(
                        '<tr>' +
                            '<td>' + contact.name + '</td>' +
                            '<td>' + contact.email + '</td>' +
                            '<td>' + contact.subject + '</td>' +
                            '<td>' + contact.message + '</td>' +
                            '<td>' +
                                '<button class="btn btn-warning btn-sm edit-btn" data-id="' + contact.id + '">Edit</button> ' +
                                '<button class="btn btn-danger btn-sm delete-btn" data-id="' + contact.id + '">Delete</button>' +
                            '</td>' +
                        '</tr>'
                    );
                });
            },
            error: function(xhr, status, error) {
                console.error('Failed to fetch contacts:', error);
            }
        });
    }

    // Initial fetch of contacts
    fetchContacts();

    // Handle form submission
    $('#contactForm').on('submit', function(event) {
        event.preventDefault(); // Prevent default form submission
        $.ajax({
            url: "<?php echo base_url('index.php/ContactController/addContact'); ?>",
            method: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(data) {
                if (data.success) {
                    $('#contactForm')[0].reset(); // Reset form
                    fetchContacts(); // Refresh table
                    $('.sent-message').text(data.message).show();
                    $('.error-message').hide();
                } else {
                    $('.error-message').text(data.message).show();
                    $('.sent-message').hide();
                }
            },
            error: function(xhr, status, error) {
                console.error('Form submission failed:', error);
                $('.error-message').text('An error occurred. Please try again.').show();
                $('.sent-message').hide();
            }
        });
    });

    // Handle delete button click
    $('#contactTable').on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        if (confirm('Are you sure you want to delete this contact?')) {
            $.ajax({
                url: "<?php echo base_url('index.php/ContactController/deleteContact/'); ?>" + id,
                method: "POST",
                dataType: "json",
                success: function(data) {
                    if (data.success) {
                        fetchContacts(); // Refresh table
                    } else {
                        alert(data.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Failed to delete contact:', error);
                    alert('An error occurred. Please try again.');
                }
            });
        }
    });

    // Handle edit button click
    $('#contactTable').on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        $.ajax({
            url: "<?php echo base_url('index.php/ContactController/getContact/'); ?>" + id,
            method: "GET",
            dataType: "json",
            success: function(data) {
                if (data.success) {
                    // Populate form fields with contact data
                    $('[name="name"]').val(data.contact.name);
                    $('[name="email"]').val(data.contact.email);
                    $('[name="subject"]').val(data.contact.subject);
                    $('[name="message"]').val(data.contact.message);
                    // Add a hidden field to store the contact ID
                    if ($('#contactForm input[name="id"]').length === 0) {
                        $('#contactForm').append('<input type="hidden" name="id" value="' + id + '">');
                    } else {
                        $('#contactForm input[name="id"]').val(id);
                    }
                } else {
                    alert(data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Failed to fetch contact details:', error);
                alert('An error occurred. Please try again.');
            }
        });
    });
});

</script>