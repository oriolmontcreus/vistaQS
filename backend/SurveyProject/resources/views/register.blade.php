<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="./css/auth/register.css">
</head>
<body>
    <div class=formContainer>
        <form method="POST" action="">
            @csrf
            <div class="form__group field">
                <input type="input" class="form__field" placeholder="Name" required="">
                <label for="name" class="form__label">Name</label>
            </div>
            <div class="form__group field">
                <input type="input" class="form__field" placeholder="Email" required="">
                <label for="email" class="form__label">Email</label>
            </div>
            <div class="form__group field">
                <input type="input" class="form__field" placeholder="City" required="">
                <label for="city" class="form__label">City</label>
            </div>
            <div class="form__group field" 
            style="display: flex;justify-content: center;align-items: center;">
            <button class="submit">Register</button>
            </div>
            <!-- test -->
        </form>
    </div>
</body>
</html>