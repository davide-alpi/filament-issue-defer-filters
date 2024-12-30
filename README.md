# How to reproduce

Copypaste the ListUser.php file in your working filament project, inside app/Filament/Resources/UserResource/Pages folder and check the github issue I opened.

This example filters users by email, filtering those containing "gmail" or "yahoo". You can filter something more relevant to your seeded users, but this is not important, the example will still work (it will select all users as soon as you select the null option in the select, since query is immediately run without deferring).
