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
