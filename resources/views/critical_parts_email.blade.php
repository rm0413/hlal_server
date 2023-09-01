<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>
    hr {
        display: block;
        height: 1px;
        border: 0;
        border-top: 1px solid #ccc;
        margin: 1em 0;
        padding: 0;
    }

    td {
        border: 1px solid black;
        border-collapse: collapse;
        padding: 10px;
        font-size: 15px;
    }

    th {
        background: #a30b1a;
        color: white;
        padding: 10px;
        font-size: 15px;
    }
</style>

<body>
    <h4>Notice:</h4>
    <p style="color: #a30b1a;">Please be informed that this is a system generated email and all replies to this email
        will go through an unmonitored mailbox.</p>
    <hr>
    <p>Hello!</p>
    <p><strong>Below item have Critical Dimension and need to have data of CPK.</strong></p>
    <p>Please update</p>
    <table style="width: 100%; text-align: center;">
        <tr>
            <th style="width: 8%;">TRI NUMBER</th>
            <th style="width: 8%;">PART NUMBER</th>
            <th style="width: 8%;">DIMENSION</th>
        </tr>
        @foreach ($yes_datastorage as $data)
            <tr>
                <td>{{ $data['tri_number'] }}</td>
                <td>{{ $data['part_number'] }}</td>
                <td>{{ $data['dimension'] }}</td>
            </tr>
        @endforeach
    </table>

    <p>Thank you,<br>Parts PE</p>
    <br>
    <br>
    <br>
    <h5>Click <a href="http://10.164.58.62/FDTP-Portal/public/login">here</a> to visit FDTP-Portal.</h5>
    <br>
    <br>
    <br>
    <div style="font-size: 10px;">
        <p>DISCLAIMER<br>This email including the information and attachments may contain confidential, copyright and/or
            privileged material that is solely for the use of the intended recipient/s or entity to whom it is addressed
            and other authorized to receive it.
            If you are not the intended recipient it is hereby brought to your notice that any disclosure, copying,
            distribution, or dissemination, or alternatively taking of any action in reliance to this, is strictly
            prohibited.
            If you received this email with inaccuracy/error, please notify the sender by reply, mail or telephone and
            delete the original message from your email system immediately.</p>
    </div>
</body>

</html>
