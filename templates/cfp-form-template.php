<?php

/**
 * Template for the CFP form
 * 
 * @version 1.0.1
 */

defined('ABSPATH') || exit;

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CFP Form</title>

  <!-- Usingg tailwind css for css  -->
  <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">

</head>

<body>
  <div class="cfp_form_wrapper ">
    <div class="shadow py-6 bg-red-50">
      <form id="cfp_form_template_101" action="" method="post" >

        <table>

          <tr>
            <td class="px-6 py-3" id="cfp_test_name">
              <label name="name " for="name">Name</label>
            </td>
            <td class="px-6 py-3">
              <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                type="text" name="name" id="cfp_from_name" placeholder="Enter your name..." required>
            </td>
          </tr>
          <tr>
            <td class="px-6 py-3 " colspan="2">
              <span id="cfp_validation_message_displayer_name" class="cfp_validation_message_display_frontend" > </span>
            </td>
          </tr>

          <tr>
            <td class="px-6 py-3">
              <label for="email">Email</label>
            </td>
            <td class="px-6 py-3">
              <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                type="email" name="email" id="cfp_from_email" placeholder="Enter your email..." required  >
            </td>
          </tr>
          <tr>
            <td class="px-6 py-3 " colspan="2">
              <span id="cfp_validation_message_displayer_email" class="cfp_validation_message_display_frontend"> </span>
            </td>
          </tr>

          <tr>
            <td class=" px-6 py-3 ">
              <label for="cfp_form_subject">Subject</label>
            </td>
            <td class="px-6 py-3">
              <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                type="text" name="subject" id="cfp_form_subject" placeholder="Enter subject of query...">
            </td>
          </tr>
          <tr>
            <td class="px-6 py-3 " colspan="2">
              <span id="cfp_validation_message_displayer_subject" class="cfp_validation_message_display_frontend"> </span>
            </td>
          </tr>

          <tr>
            <td class="px-6 py-3">
              <label for="cfp_form_message">Message</label>
            </td>
            <td class="px-6 py-3">
              <textarea id="cfp_form_message" rows="4"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="message"
                placeholder="Write your message here..."></textarea>

            </td>
          </tr>
          <tr>
            <td class="px-6 py-3 " colspan="2">
              <span id="cfp_validation_message_displayer_message" class="cfp_validation_message_display_frontend"> </span>
            </td>
          </tr>

          <tr>
            <td class="px-6 py-3 ">
              <input id="cfp_form_btn"
                class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500  rounded"
                type="submit" value="Send Quote" />
            </td>
          </tr>

          <tr>
            <td class="px-6 py-3 " colspan="2">
              <span id="cfp_validation_message_displayer_default" class="cfp_validation_message_display_frontend"> </span>
            </td>
          </tr>

        </table>

    </div>
    </form>
  </div>
</body>

</html>