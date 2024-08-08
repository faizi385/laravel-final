<!DOCTYPE html>
<html>
<head>
    <title>Reservation Details</title>
</head>
<body>
    <h1>Reservation Details</h1>
    <p>Name: {{ $reservationData['name'] }}</p>
    <p>Email: {{ $reservationData['email'] }}</p>
    <p>Phone Number: {{ $reservationData['phone_number'] }}</p>
    <p>Location to Visit: {{ $reservationData['location_to_visit'] }}</p>
    <p>Check-in Date: {{ $reservationData['check_in_date'] }}</p>
    <p>Check-out Date: {{ $reservationData['check_out_date'] }}</p>
    <p>Number of Guests: {{ $reservationData['number_of_guests'] }}</p>
    <p>Any Kids: {{ $reservationData['any_kids'] ? 'Yes' : 'No' }}</p>
    <p>Message: {{ $reservationData['message'] }}</p>
</body>
</html>
