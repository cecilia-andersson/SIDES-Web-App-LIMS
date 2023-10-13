<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <link href="../images/SIDES_head_icon.png" rel="icon">
    <link rel="stylesheet" type="text/css" href="../stylesheet/styles.css">
    <style>
        body {}

        .register-button {}

        ol { counter-reset: item }
        li{ display: block }
        li:before { content: counters(item, ".") " "; counter-increment: item }
    </style>
</head>


<body>
    <header>
        <?php
        include "../navigation.php";
        ?>
    </header>
    <h2> Privacy Policy </h2>

    <br><section>
    <p> This privacy policy aims to explain how SIDES uses the personal 
    data we collect from you when we use your website, as well as your 
    rights to your data and how to exercise them. Below is a schema of 
    the policy. <p>
    <ol> 
        <li> <b>Data Collection & Use</b> 
            <ol>
                <li>What data do we collect? How will we use this data?</li>
                <li>How do we collect your data?</li>
                <li>How do we store your data?</li>
            </ol>
        </li>
        <li> <b>Cookies</b>
            <ol>
                <li>Marketing</li>
                <li>What are cookies</li>
                <li>What types of cookies do we use, and how do we use them?</li>
                <li>How to manage your cookies</li>
            </ol>
        </li>
        <li> <b>Your Rights</b>
            <ol>
                <li>What are your data protection rights?</li>
                <li>Changes to our privacy policy</li>
                <li>How to contact us</li>
                <li>How to contact authorities</li>
            </ol>
        </li>
    </ol>

    More information about the European Union General Data Protection Regulation 
    (GDPR) is available here: <a href="https://gdpr-info.eu/">General Data Protection Regulation</a> (2016).

    More information about Sweden's specific data protection regulations is 
    available here: 
    <a href="https://www.riksdagen.se/sv/dokument-och-lagar/dokument/svensk-forfattningssamling/lag-2018218-med-kompletterande-bestammelser_sfs-2018-218/">Act with Supplementary Provisions to the GDPR</a>
    (Lag 2018:218) and here: 
    <a href="https://www.riksdagen.se/sv/dokument-och-lagar/dokument/svensk-forfattningssamling/forordning-2018219-med-kompletterande_sfs-2018-219/">Act with Supplementary Provisions to the GDPR</a>
    Ordinance with Supplementary Provisions to the GDPR (Förodning 2018:219).
    
    <ol> 
        <li> <b>Data Collection & Use</b> 
            <ol>
                <li>What data do we collect? How will we use this data? 
                <p style="color: #8f8f8f";> SIDES collects the following data from logged-in users:
                <ol style="color: #8f8f8f";> 
                    <li>Personal identification information (Personnummer, email address, age)</li>
                    <li>Username</li>
                    <li>Password</li>
                    <li>Health information (self-reported contraceptive use, self-reported health symptoms)</li>
                </ol>
                </p>
                <p style="color: #8f8f8f";> 
                A brief outline of the data SIDES collects, as well as information about its use and storage, is found in the below table:
                    <table style="color: #8f8f8f";>
                    <tr>
                        <th>Data</th><th>Classification</th><th>Storage period</th><th>Use justification</th>
                    </tr>
                    <tr>
                        <td>User ID</td><td>Personal Data</td><td>80 years</td>
                        <td>Randomized personal identifier to store in cookie while user is logged in; removes need to store more directly 
                            identifiable information in cookies, while still allowing identification in database across web pages</td>
                    </tr>
                    <tr>
                        <td>Email address</td><td>Personal Data</td><td>80 years</td>
                        <td>Account security: used for account recovery after loss of password; 2-factor authentication</td>
                    </tr>
                    <tr>
                        <td>Username</td><td>Personal Data</td><td>80 years</td>
                        <td>Facilitates anonymous but logical posting and discussions on the discussion forum</td>
                    </tr>
                    <tr>
                        <td>Password</td><td>Personal Data</td><td>80 years</td>
                        <td>User authentication and account security</td>
                    </tr>
                    <tr>
                        <!-- Is this sensitive?-->
                        <td>Personnummer</td><td>Personal Data</td><td>80 years</td>
                        <td>Ensures each user is unique, a person, and has only one account; used to derive accurate age</td>
                    </tr>
                    <tr>
                        <td>Age (derived)</td><td>Personal Data</td><td>80 years</td>
                        <td>Analytics: used to group side effects by age categories</td>
                    </tr>
                    <tr>
                        <td>Contraceptive used</td><td>Sensitive Personal Data</td><td>30 years</td>
                        <td>Analytics: used to associate symptoms with a contraceptive used during a defined period of time. 
                            Also used to verify that a user is eligible to review a drug.</td>
                    </tr>
                    <tr>
                        <td>Reported Symptoms</td><td>Sensitive Personal Data</td><td>30 years</td>
                        <td>Analytics: used to create individual and compiled statistics of side effects on a particular 
                            contraceptive; also may be used for recommendations in future.</td>
                    </tr>
                    </table>
                </p>
                </li>
                <li>How do we collect your data?
                <p style="color: #8f8f8f";> You directly provide SIDES with all the personal data we collect. This occurs during actions on our website, such as:
                <ol style="color: #8f8f8f";> 
                    <li>Account registration (username, personnummer, password, email address)</li>
                    <li>Submitting information forms (“Add contraceptive,” “Report symptoms”)</li>
                </ol>
                </p>
                </li>
                <li>How do we store your data?
                <p style="color: #8f8f8f";> 
                SIDES stores your data securely on a local server. Unless you request that SIDES remove your data (see section 3.1), 
                your personal data is stored in this location for up to 80 years. Some categories of data are stored for less time, as 
                listed in section 1.1. After this time period expires, your personal data is automatically deleted.
                </p>
                </li>
            </ol>
        </li>
        <li> <b>Cookies</b>
            <ol>
                <li>Marketing</li>
                <p style="color: #8f8f8f";> 
                Currently, SIDES does not engage in marketing.<br/> 
                <br/> 
                However, in the future SIDES may like to send you information about products and services we think you will like. 
                SIDES does not currently have partner companies, but any added in the future will be added here.<br/> 
                <br/> 
                If you have agreed to receive marketing from SIDES and its partners, you can always opt out at a later date.<br/> 
                <br/> 
                You have the right at any time to stop SIDES or its partners from contacting you for marketing purposes, and you 
                have the right to stop SIDES from distributing your data to its partners.

                </p>
                <li>What are cookies?</li>
                <p style="color: #8f8f8f";> According to the European Data Commission, “cookies are text files placed on your computer 
                to collect standard internet log information and visitor behavior information.” When you visit SIDES, we may collect 
                information about you automatically using a small number of cookies. 
                </p>
                <li>What types of cookies do we use, and how do we use them?</li>
                <p style="color: #8f8f8f";> SIDES uses a limited amount of cookies to improve your experience of our website. The 
                primary use of cookies on our website is to keep you signed in as you move around on our site. Therefore, SIDES uses 
                the following cookies:<br/> 
                <br/> 
                Session management cookies: A Session ID cookie, with a single associated stored variable: user ID. This cookie expires 
                at the end of the session.
                </p>
                <li>How to manage your cookies</li>
                <p style="color: #8f8f8f";> To reject SIDES' use of cookies at any time, you can: 1. Set your web browser to not allow 
                cookies. 2. Reject the use of cookies in the pop-up at the start of a session. 3. Reject the use of cookies on the 
                Privacy Policy page.  Unfortunately, logged-in users may lose some website functionality when rejecting SIDES' use of cookies.
                </p>
            </ol>
        </li>
        <li> <b>Your Rights</b>
            <ol>
                <li>What are your data protection rights?</li>
                <p style="color: #8f8f8f";> 
                According to the GDPR, every user of the SIDES platform has the following data rights: <br/> 
                <br/> 
                <i>Right to be informed about processing:</i> You have the right to be informed about what personal data SIDES collects 
                    from you, as well as information about this storage (how it is stored, how long it is stored, what it is used for).<br/> 
                <br/> 
                <i>Right to Object and Right to Restriction of Processing:</i> You have the right to object to SIDES' processing of your 
                personal data, under certain conditions. You also have the right to request that SIDES restrict the processing of your 
                personal data, under certain conditions.<br/> 
                <br/> 
                <i>Right of Access and Right to Rectification:</i> You have the right to request copies of all the personal data SIDES 
                    collects from you. This is free of charge. You also have the right to request that SIDES correct or amend any 
                    information you believe is inaccurate or incomplete.<br/> 
                <br/> 
                <i>Right to portability:</i> You have the right to request that SIDES transfer the data that we have collected to you, 
                    or another organization, under certain circumstances. This transfer is free of charge, and the data will be 
                    delivered in an organized, machine-readable format.<br/> 
                <br/> 
                <i>Right to erasure:</i> At any point in time, you have the right to request the erasure of any or all data SIDES 
                    has collected about you, under certain conditions.<br/> 
                <br/> 
                <i>Right to not be subject to a decision based solely on automated processing:</i> You have the right not to be subject 
                    to a decision based solely on automated processing, including profiling, which produces legal effects concerning you 
                    (or similarly significantly affects you), under certain conditions. <br/> 
                <br/> 
                If you make an aforementioned request, SIDES has <b>one month</b> to respond to you. If you would like to exercise any of 
                these rights, please contact us at: <br/> 
                <br/> 
                <b>sideslims@gmail.com</b>

                </p>
                <li>Changes to our privacy policy</li>
                <p style="color: #8f8f8f";> 
                Any updates to our privacy policy are placed on our webpage. This privacy policy was last updated on 12 October 2023.
                </p>
                <li>How to contact us</li>
                <p style="color: #8f8f8f";> 
                If you have any questions about the data we collect from you, this privacy policy, or any requests regarding your 
                rights to your data, please contact us by email:
	
	            <b>sideslims@gmail.com</b>
                </p>
                <li>How to contact authorities</li>
                <p style="color: #8f8f8f";> 
                If you wish to report a complaint or if you feel SIDES has not addressed your concerns about your personal data in 
                a satisfactory manner, you may contact the Information Commissioner's office.
                </p>
            </ol>
        </li>
    </ol>



    <?php
    include "../footer.php";
    ?>
</body>

</html>