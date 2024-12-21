# Create a new Maven Project
```shell
mvn -B archetype:generate \
 -DarchetypeGroupId=software.amazon.awssdk \
 -DarchetypeArtifactId=archetype-lambda -Dservice=s3 -Dregion=EU_CENTRAL_1 \
 -DarchetypeVersion=2.29.39 \
 -DgroupId=com.example.myapp \
 -DartifactId=myapp
```
