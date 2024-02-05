import com.fasterxml.jackson.core.JsonProcessingException;
import com.fasterxml.jackson.databind.ObjectMapper;

class Main 
{
    public static void main( String[] args ) throws JsonProcessingException
    {
         // Пример массива
      int[] array = {5,4,2};
      MyObject object = new MyObject("Ayan", 20);
      // Преобразование массива в JSON строку
      System.out.println(new ObjectMapper().writeValueAsString(object));
    }
}

class MyObject {
  public String name;
  public int age;
  public MyObject(String name, int age){
    this.name = name;
    this.age = age;
  }
}

