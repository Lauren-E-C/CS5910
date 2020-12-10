<?php
$roles = ['Student', 'Admin', 'Instructor', 'Researcher'];
$page_title = "Course Catalog";
include_once 'header.php';
?>

<?php error_reporting (E_ALL ^ E_NOTICE); ?> <!-- get rid of undefined index for GET -->


<form action="" method="GET">
    <select name="semester">
        <option value="select"selected>Select Listing</option>
        <option value="ACC">Accounting</option>
        <option value="ADO">Adolescence Education</option>
        <option value="ARS">African/African-American Studies</option>
        <option value="ASL">American Sign Language</option>
        <option value="AMS">American Studies</option>
        <option value="ANT">Anthropology</option>
        <option value="ARA">Arabic</option>
        <option value="ART">Art</option>
        <option value="ARH">Art History</option>
        <option value="AST">Astronomy</option>
        <option value="BIO">Biology</option>
        <option value="BRC">Broadcasting and Mass Communication</option>
        <option value="BUS">Business</option>
        <option value="BLW">Business Law</option>
        <option value="CTE">Career & Technical Educator</option>
        <option value="CHE">Chemistry</option>
        <option value="CED">Childhood Education</option>
        <option value="CHI">Chinese</option>
        <option value="CSS">Cinema Screen Studies</option>
        <option value="COG">Cognitive Science</option>
        <option value="COM">Communication</option>
        <option value="CMA">Communication, Media and the Arts</option>
        <option value="CAS">College of Arts and Sciences</option>
        <option value="CSC">Computer Science</option>
        <option value="CPS">Counseling and Psychological Services</option>
        <option value="CRW">Creative Writing Arts</option>
        <option value="CRJ">Criminal Justice</option>
        <option value="DNC">Dance</option>
        <option value="ECH">Early Childhood Education</option>
        <option value="ECO">Economics</option>
        <option value="EDU">Education</option>
        <option value="ECE">Electrical and Computer Engineering</option>
        <option value="ENG">English</option>
        <option value="FIN">Finance</option>
        <option value="FRE">French</option>
        <option value="GWS">Gender & Women’s Studies</option>
        <option value="GST">General Studies</option>
        <option value="GCH">Geochemistry</option>
        <option value="GEG">Geography</option>
        <option value="GEO">Geology</option>
        <option value="GER">German</option>
        <option value="GRT">Gerontology</option>
        <option value="GLS">Global and International Studies</option>
        <option value="HSC">Health Science</option>
        <option value="HIS">History</option>
        <option value="HON">Honors</option>
        <option value="HDV">Human Development</option>
        <option value="HRM">Human Resource Management</option>
        <option value="ISC">Information Science</option>
        <option value="IST">International Studies</option>
        <option value="INT">Interpretation</option>
        <option value="ITA">Italian</option>
        <option value="JPN">Japanese</option>
        <option value="JLM">Journalism</option>
        <option value="LIN">Linguistics</option>
        <option value="LIT">Literacy Education</option>
        <option value="MGT">Management</option>
        <option value="MKT">Marketing</option>
        <option value="MAT">Mathematics</option>
        <option value="MAX">Mathematics: Foundational</option>
        <option value="MDS">Medieval and Renaissance Studies</option>
        <option value="MET">Meteorology</option>
        <option value="MUS">Music</option>
        <option value="NAS">Native American Studies</option>
        <option value="OCE">Oceanography</option>
        <option value="PCS">Peace and Conflict Studies</option>
        <option value="PHL">Philosophy</option>
        <option value="PPE">Philosophy, Politics and Economics</option>
        <option value="PED">Physical Education</option>
        <option value="PHY">Physics</option>
        <option value="POL">Political Science</option>
        <option value="POR">Portuguese</option>
        <option value="PSY">Psychology</option>
        <option value="PRL">Public Relations</option>
        <option value="RMI">Risk Management and Insurance</option>
        <option value="SOC">Sociology</option>
        <option value="SPA">Spanish</option>
        <option value="SPE">Special Education</option>
        <option value="SUS">Sustainability</option>
        <option value="TEL">Technical Education</option>
        <option value="TED">Technology Education</option>
        <option value="TSL">TESOL</option>
        <option value="THT">Theatre</option>
        <option value="ZOO">Zoology</option>

    </select>

    <!-- submit button-->
    <input type="submit" value="Submit" />
</form>


<div class="container">
    <table class="table">
        <tr>
            <th>Department Code</th>
            <th>Course Name</th>
            <th>Course Number</th>
            <th>Description</th>
            <th>Level</th>
            <th>Prerequisites</th>
            <th>Credits</th>
        </tr>