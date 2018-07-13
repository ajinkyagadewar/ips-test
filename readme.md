## Assignment

Create an API endpoint that adds the correct “Start module reminder” tag to Infusionsoft contact based on order in which they bought courses and their progress in modules. 

Order is always starting from first bought course (first in Infusionsoft field “products”) and first module of it, to last course and last module of it. 

i.e. If customer has bought “ipa,iaa”, then order is: IPA M1, IPA M2, ... , IPA M7, IAA M1, IAA M2, … , IAA M7

Module completion order doesn't matter.

Customer can also have only one course. In that case order is IPA M1, … , IPA M7

## Approach

- Methodology used - Test Driven Development
- Design Patterns - Singleton, Repository and Factory Pattern
- Environments - Development and Testing
- Databases - MySQL for Development and SQLite for Testing
- Mocking is used for Testing External APIs
- Interfaces created for => Tags, Users and Reminders
- Events used to create Contacts in Infusion Soft as soon as user is created in portal
- Traits used in test to remove redundant code

## Best Points

- Code will work for any number of courses and modules
- Highly flexible 
- Very low coupled
- Interfaces used to interact with low level business logic
- PHPMetrics shows it to be a high quality code. Added CodeCoverage report

