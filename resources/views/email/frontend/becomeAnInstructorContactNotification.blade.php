<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .content {
            font-size: 16px;
            line-height: 1.5;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #777777;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="content">
            <p>Dear Admin,</p>
            <p>A new "Become an Instructor" form has been submitted on Skill Vedika. Here are the details for your records:</p>
            <ul>
                <li style="list-style: none;"><strong>Details:</strong>
                    <ul>
                        <li><strong>Name:</strong> {{ $name }} </li>
                        <li><strong>Phone:</strong> {{ $phone }} </li>
                        <li><strong>Email:</strong> {{ $email }} </li>
                        <li><strong>Course Name:</strong> {{ $course_name }} </li>
                        <li><strong>Contact Date:</strong> {{ $date }} </li>
                    </ul>
                </li>
            </ul>
            <p>This notification is for your awareness and monitoring of the activities on the platform. Please reach out if you have any questions or need further information.</p>
            <p>Best regards,<br>The <i>Skill Vedika</i> Team</p>
        </div>
        <!-- <div class="footer">
            <p>© 2024 Your Company Name. All rights reserved.</p>
        </div> -->
    </div>
</body>

</html>
