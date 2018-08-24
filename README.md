Feature toggle
==============

A demonstration of how to use the concept of Feature Toggle, changing an application behavior at runtime without making any deploy.

# Running the project

You only need to have a docker installed on your computer. All the dependencies are managed with it.

```
# Build the image
$ docker build -t moriorgames/feature-toggle-php .
# Run the container
$ docker run -td --name feature_toggle -p 8085:8085 moriorgames/feature-toggle-php
# Go to the main URL
$ http://localhost:8085/ 
```

# The problem

In complex systems the maintenance of the parts that define the business rules is usually painful.

From management having fragility at this step is not tolerable so they limit the modification of those parts. Even management put controls to not allow task that can produce alterations in that portion of the system.

This makes developers have to take shortcuts to complete their daily tasks. Taking shortcuts causes the increase of the entropy of a system. Every time any task is completed, the system becomes more complex in any direction. Like an oil stain growing to all directions.

The system becomes increasingly difficult to maintain and understand. The delivery speed of the IT team falls. And the most important thing: since this complex part contains the business rules, when these change, the development team must make an heroic to adapt to the new requirements. With a lot of risks.

# The solution

A possible approach to solve this problem is to have all the business rules under automated tests. Obviously, the system has been designed in a way that testing each and every one of the rules would be such an effort that it seems an impossible task to do. But with the help of the wise Roman emperors and design patterns we can apply a "Dīvide et īmpera" to our code with the aim of submitting automated tests one by one the pieces of our system.

Another advantage of dividing our system into small pieces is that their understanding of it becomes simpler. Entropy is reduced. Tests becomes documentation. In addition, by dividing the system into small pieces we can progressively replace the complex system with each of the pieces, reducing the maintenance cost. And we can validate in the production environment that the new piece introduced works as expected.

# Future benefits

The final result of split the system into smaller pieces leave us in a state of experimentation. We will be able to replace pieces at runtime without any deploy to production and take risks or rollbacks when needed.

# Go to the code

To do the exercise, I used PHP, but I could have used any other object-oriented language, the concepts are equally usable.

We will give the example of a complex system of validation of a purchase order.

- Step 1: [The starting point](https://github.com/moriorgames/feature-toggle-php/blob/master/docs/step1.md)