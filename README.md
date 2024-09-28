##### Para la versión en español revisa [README_ESPAÑOL](README_ES.md)

# FormAPI
The **FormAPI** class is a PHP utility designed for PocketMine-MP, allowing the creation and display of various types of interactive forms. It supports Simple Forms, Modal Forms, and Custom Forms, which provide different functionalities based on user input.

## Setup
To set up the FormAPI in your PocketMine-MP project, follow these steps:
1. **Download the Release:** First, download the latest release from this repository. You will receive a compressed file containing all necessary files.
2. **Extract the Files:** Extract the contents of the downloaded release to the `src` directory of your PocketMine-MP project. The folder structure should look like this:
   ```scss
   YourPlugin/
   src/
     yourName/
       ...
     formspm/
       ...
    ```
3. **Including the FormAPI Class:** In your project files, include the necessary FormAPI classes using the appropriate namespace:
   ```php
   use formspm\kamy\Form;
   use formspm\kamy\FormType;
   ```

## Simple Form
A **SimpleForm** is a basic form that contains a title and multiple buttons. Each button triggers an action depending on the user's selection.
Here is an example of how to create a Simple Form:
```php
// Create a new Simple Form instance
$form = Form::create(FormType::SIMPLE_FORM);

// Set the title of the formspm
$form->setTitle("Simple Form");

// Add buttons to the formspm. Each button is assigned an index starting from 0.
// In this case, "Button 1" has index 0, and "Button 2" has index 1.
$form->addButton("Button 1");
$form->addButton("Button 2");

// Set the action to be executed when the player submits the formspm.
// The second argument, $buttonId, represents the index of the button that was pressed.
$form->setSubmitAction(function (Player $player, int $buttonId) {
    // Switch case to handle different button presses
    switch ($buttonId) {
        case 0:
            // If Button 1 (index 0) was pressed
            $player->sendMessage("You pressed Button 1.");
            break;
        case 1:
            // If Button 2 (index 1) was pressed
            $player->sendMessage("You pressed Button 2.");
            break;
        default:
            // Fallback if an unknown button was pressed (though it shouldn't happen with valid buttons)
            $player->sendMessage("Unknown button pressed.");
            break;
    }
});

// Send the formspm to the player, displaying it in their client
$form->send($player);
```

### Functions
1. **setTitle(string $title): void**
   - Sets the title of the form.
   - **Example:**
     ```php
     $form->setTitle("Simple Form");
     ```
2. **addButton(string $text): void**
   - Adds a button to the form.
   - **Example:**
     ```php
     $form->addButton("Button 1");
     ```  
3. **setSubmitAction(Closure $action): void**
   - Defines the action to execute when a button is pressed. The action is defined by a Closure that takes the player and the button ID as parameters.
   - **Example:**
     ```php
     $form->setSubmitAction(function (Player $player, int $buttonId) {
         // Handle button press
     });
     ```
4. **send(Player $player): void**
   - Sends the form to the player.
   - **Example:**
     ```php
     $form->send($player);
     ```

## Modal Form
A **Modal Form** provides two options (usually "Yes" or "No") and is useful for confirmation dialogs.
Here is an example of how to create a Modal Form:
```php
// Create a new Modal Form instance
$form = Form::create(FormType::MODAL_FORM);

// Set the title of the modal formspm
$form->setTitle("Modal Form");

// Set the content or message displayed in the modal formspm
$form->setContent("Do you want to proceed?");

// Set the labels for the two buttons. Button 1 is for "Yes" and Button 2 is for "No".
// These buttons are presented as options for the player to choose from.
$form->setButton1("Yes");
$form->setButton2("No");

// Set the action to be executed when the player submits the modal formspm.
// The $buttonId represents the index of the button pressed by the player.
// For a modal formspm, Button 1 ("Yes") corresponds to index 0, and Button 2 ("No") corresponds to index 1.
$form->setSubmitAction(function (Player $player, int $buttonId) {
    // Check if the "Yes" button (index 0) was pressed
    if ($buttonId === 0) {
        // Send a message to the player indicating they pressed "Yes"
        $player->sendMessage("You pressed 'Yes'.");
    } else {
        // If the "No" button (index 1) was pressed, send this message
        $player->sendMessage("You pressed 'No'.");
    }
});

// Send the modal formspm to the player
$form->send($player);
```

### Functions
1. **setTitle(string $title): void**
   - Sets the title of the form.
   - **Example:**
     ```php
     $form->setTitle("Modal Form");
     ```
2. **setContent(string $content): void**
   - Sets the content (main message) of the modal.
   - **Example:**
     ```php
     $form->setContent("Do you want to proceed?");
     ```
3. **setButton1(string $text): void**
   - Sets the text for the first button (usually the "Yes" button).
   - **Example:**
     ```php
     $form->setButton1("Yes");
     ```
4. **setButton1(string $text): void**
   - Sets the text for the second button (usually the "No" button).
   - **Example:**
     ```php
     $form->setButton2("No");
     ```
5. **setSubmitAction(Closure $action): void**
   - Defines the action to be executed when one of the buttons is pressed.
   - **Example:**
     ```php
     $form->setSubmitAction(function (Player $player, int $buttonId) {
         // Handle button press
     });
     ```

## Custom Form
A **Custom Form** allows for more complex input, such as text fields, sliders, and dropdowns.
Here is an example of how to create a Custom Form:
```php
// Create a new Custom Form instance
$form = Form::create(FormType::CUSTOM_FORM);

// Set the title of the custom formspm
$form->setTitle("Custom Form");

// Add an input field where the player can enter their name
// The first parameter is the label shown to the player, and the second is a placeholder text
$form->addInput("What is your name?", "E.g. John");

// Add a slider where the player can select their age
// The slider allows selecting a value between 0 and 100, with 18 being the default value
$form->addSlider("Select your age", 0, 100, 18);

// Add a dropdown list for the player to choose a color
// The dropdown contains three options: "Red", "Green", and "Blue"
$form->addDropdown("Choose a color", ["Red", "Green", "Blue"]);

// Set the action to be performed when the formspm is submitted
// The $data array contains the player's responses: $data[0] is the name, $data[1] is the selected age, and $data[2] is the chosen color
$form->setSubmitAction(function (Player $player, $data) {
    // Get the name entered by the player; if none is entered, default to "None"
    $name = $data[0] ?? "None";
    
    // Get the age selected by the player from the slider; if no value is provided, default to 0
    $age = $data[1] ?? 0;
    
    // Get the color selected by the player from the dropdown; if none is selected, default to "None"
    $color = $data[2] ?? "None";
    
    // Send a message to the player summarizing their inputs: name, age, and chosen color
    $player->sendMessage("Name: $name, Age: $age, Color: $color");
});

// Send the custom formspm to the player for interaction
$form->send($player);
```

### Functions
1. **setTitle(string $title): void**
   - Sets the title of the form.
   - **Example:**
     ```php
     $form->setTitle("Custom Form");
     ```
2. **addInput(string $placeholder, ?string $default = null): void**
   - Adds an input field where the player can type text.
   - **Example:**
     ```php
     $form->addInput("What is your name?", "E.g. John");
     ```
3. **addSlider(string $label, float $min, float $max, float $default): void**
   - Adds a slider input where the player can select a value within a range.
   - **Example:**
     ```php
     $form->addSlider("Select your age", 0, 100, 18);
     ```
4. **addDropdown(string $label, array $options): void**
   - Adds a dropdown menu where the player can select from a list of options.
   - **Example:**
     ```php
     $form->addDropdown("Choose a color", ["Red", "Green", "Blue"]);
     ```
5. **setSubmitAction(Closure $action): void**
   - Defines the action to be executed when the form is submitted.
   - **Example:**
     ```php
     $form->setSubmitAction(function (Player $player, $data) {
         // Handle formspm submission
     });
     ```

# License
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for more information.
