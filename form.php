<?php
function validate_message($message)
{
    // Function to check if message is correct (must have at least 10 characters after trimming)
    $trimmed_message = trim($message); // cắt các ký tự trắng ở 2 đầu
    $regex = '/^.{10,}$/';// Biểu thức chính quy '/^.{10,}$/' được sử dụng để kiểm tra xem một chuỗi có ít nhất 10 ký tự hay không

        if (preg_match($regex, $trimmed_message)) { // kiểm tra nhập vào có đúng với biểu thức chính quy hay ko , 1 nếu kq đúng, 0 nếu kq sai
            return true;
        } else {
            return false;
        }
}

function validate_username($username)
{
    // function to check if username is correct (must be alphanumeric => Use the function 'ctype_alnum()')

    /// str_replace  thay thế các kí tự " " = ""
    /// trim cắt các kí tự trắng ở 2 đầu
    /// crybe_alnum kiểm tra các kí tự trong chuỗi có  phải là số và chữ không
    if (ctype_alnum(trim($username))) {
        return true;
    } else {
        return false;
    }
}

function validate_email($email)
{
    // Function to check if email is correct (must contain '@')
    $regex = '/@/'; // biểu thức chính quy

    if (preg_match($regex, $email)) { // kiểm tra chuỗi nhâp vào có khớp với biểu thức chính quy hay ko
        return true;
    } else {
        return false;
    }
}

$user_error = "";
$email_error = "";
$terms_error = "";
$message_error = "";
$username = "";
$email = "";
$message = "";

$form_valid = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Here is the list of error messages that can be displayed:
    //
    // "Message must be at least 10 characters long"
    // "You must accept the Terms of Service"
    // "Please enter a username"
    // "Username should contain only letters and numbers"
    // "Please enter an email"
    // "Email must contain '@'"

    $username = trim(htmlspecialchars($_POST['username']));// chuyển các ksi tự đầu vào thành string      sau đó cắt các kí tự trắng 2 đầu
    $email = trim(htmlspecialchars($_POST['email']));// chuyển các ksi tự đầu vào thành string  sau đó cắt các kí tự trắng 2 đầu
    $message = trim(htmlspecialchars($_POST['message']));// chuyển các ksi tự đầu vào thành string sau đó cắt các kí tự trắng 2 đầu


    if(validate_message($message) == false){ // kiểm tra nhập vào có đúng với các yêu cầu validate của hàm hay ko
        $message_error = "Message must be at least 10 characters long";
    }
    if (validate_username($username) == false){// kiểm tra nhập vào có đúng với các yêu cầu validate của hàm hay ko
        $user_error = "Username should contain only letters and numbers";
    }
    if (validate_email($email) == false){// kiểm tra nhập vào có đúng với các yêu cầu validate của hàm hay ko
        $email_error = "Email must contain '@'";
    }
    $terms_error = empty($_POST['terms']) ? "You must accept the Terms of Service" : ""; // kiểm tra xem check box có đuọcw check hay chưa

    if (empty($user_error) && empty($email_error) && empty($terms_error) && empty($message_error)) { // kiểm tra các biến lỗi có trống không , nếu không có lỗi nào thì csc inpit đáp ứng đủ yêu cầu
        $form_valid = true; // formm thành true nếu ko có lỗi nào
    }
}
?>

<form action="#" method="post">
    <div class="row mb-3 mt-3">
        <div class="col">
            <input type="text" class="form-control" placeholder="Enter Name" name="username">
            <small class="form-text text-danger"> <?php echo htmlspecialchars($user_error); // in ra chuỗi lỗi ?></small>
        </div>
        <div class="col">
            <input type="text" class="form-control" placeholder="Enter email" name="email">
            <small class="form-text text-danger"> <?php echo htmlspecialchars($email_error);// in ra chuỗi  lỗi ?></small>
        </div>
    </div>
    <div class="mb-3">
        <textarea name="message" placeholder="Enter message" class="form-control"></textarea>
        <small class="form-text text-danger"> <?php echo htmlspecialchars($message_error);// in ra chuỗi  lỗi ?></small>
    </div>
    <div class="mb-3">
        <input type="checkbox" class="form-control-check" name="terms" id="terms" value="terms"> <label for="terms">Iaccept the Terms of Service</label>
        <small class="form-text text-danger"> <?php echo htmlspecialchars($terms_error); // in ra chuỗi  lỗi?></small>
    </div>
    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>

<hr>

<?php
if ($form_valid) :// nêu form đúng
?>
    <div class="card">
        <div class="card-header">
            <p><?php echo htmlspecialchars($username) // in ra kết các input nhập vào;?></p>
            <p><?php echo htmlspecialchars($email)// in ra kết các input nhập vào ;?></p>
        </div>
        <div class="card-body">
            <p class="card-text"><?php echo htmlspecialchars($message) // in ra kết các input nhập vào;?></p>
        </div>
    </div>
<?php
endif;
?>